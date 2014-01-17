#! /usr/bin/env python
import socket
import json
import thread
import time
import datetime
import smtplib
from email.mime.text import MIMEText
import MySQLdb
import poplib
from email import parser
host='localhost'
port=8001

def sendmail_thread(send_username,send_passwd,send_server,time_space,rec_username): 
	print "sendmail_thread is running"
	mailto_list=[rec_username]  #send to list
	mail_host=send_server   #smtp host
	mail_user=send_username #user
	mail_pass=send_passwd    #passwd
	t_space=int(time_space)
	try:
		con=MySQLdb.Connection('localhost','root','19890804','mailtest')
		cur=con.cursor()
	except:
		print "database connect error"
	cur.execute("select * from mailtest");
	i=cur.rowcount
	try:
		s = smtplib.SMTP()
		while True:
			s.connect(mail_host)
			s.login(mail_user,mail_pass)
			msg = MIMEText("mailtest")  #mail content 
			seq=str(time.time())
			msg['Subject'] = seq    #sub is  seq
			msg['From'] = mail_user
			msg['To'] = ";".join(mailto_list)
			curTime = time.strftime("%Y-%m-%d %X", time.localtime(time.time()))
			s.sendmail(mail_user, mailto_list, msg.as_string())
			#insert to database
			value=[i,seq,mail_user,rec_username,mail_host,curTime,"","",""]
			cur.execute("insert into mailtest values(%s,%s,%s,%s,%s,%s,%s,%s,%s)",value)
			con.commit()
			i=i+1
			time.sleep(t_space)
			s.close()
			print "send a mail"
	except Exception, e:
		print str(e)
	cur.close()
	con.close()

def recmail_thread(rec_username,rec_passwd):
	#host = 'pop.sina.com'
	postfix=rec_username.split('@')
	host='pop.'+postfix[1]
	username = rec_username
	password = rec_passwd
	
	while 1:
		try:
			con=MySQLdb.Connection('localhost','root','19890804','mailtest')
			cur=con.cursor()
		except:
			print "database connect error"
		print "rec_thread is running"
		cur.execute("select seq from mailtest where warn=0");
		rs=cur.fetchall()
		try:
			pop_conn = poplib.POP3(host)
			pop_conn.user(username)
			pop_conn.pass_(password)
		except:
			print "pop connect error"
		messages = [pop_conn.retr(i) for i in range(1, len(pop_conn.list()[1]) + 1)]

		# Concat message pieces:
		messages = ["\n".join(mssg[1]) for mssg in messages]

		#Parse message intom an email object:
		messages = [parser.Parser().parsestr(mssg) for mssg in messages]
		for message in messages:
			#print message['Subject']
			seq=message['Subject']
			curTime = time.strftime("%Y-%m-%d %X", time.localtime(time.time()))
			for r in rs:
				if seq==r[0]:
					cur.execute("update mailtest set rectime=%s, warn=%s  where seq=%s",(curTime,"1",seq))
					con.commit()
					cur.execute("select sendtime from mailtest where seq=%s",seq)
					stime=cur.fetchone()
					cur.execute("select rectime from mailtest where seq=%s",seq)
					rtime=cur.fetchone()
					tspace=(rtime[0]-stime[0]).seconds
					cur.execute("update mailtest set timespace=%s  where seq=%s",(tspace,seq))
					con.commit()
					#print curTime-stime[0]
			#print message['date']
			#rectime=str(message['date']).split(' ')
			#print rectime
			#mon_list=['Jan','Feb','Mar','Apr','May','June','July','Aug','Sept','Oct','Nov','Dec']
			#mon=mon_list.index(rectime[2])+1
			#rec_datetime=rectime[3]+'-'+str(mon)+'-'+rectime[1]+' '+rectime[4]
			#print curTime
		pop_conn.quit()
		time.sleep(5)
	cur.close()
	con.close()



if __name__ == '__main__':
	sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
	sock.bind((host, port))
	sock.listen(5)
	while True:
		connection,address = sock.accept()
		try:
			connection.settimeout(5)
			buf = connection.recv(1024)
			#print 'rec msg is'+buf
			msg=eval(buf)  #string->dict
			send_username= msg["send_username"]
			send_passwd= msg["send_passwd"]
			send_server= msg["send_server"]
			time_space= msg["time_space"]
			rec_username= msg["rec_username"]
			rec_passwd= msg["rec_passwd"]
			#todo
			thread.start_new_thread(sendmail_thread,(send_username,send_passwd,send_server,time_space,rec_username))
			thread.start_new_thread(recmail_thread,(rec_username,rec_passwd))
		except socket.timeout:
			print 'time out'
			connection.close()
