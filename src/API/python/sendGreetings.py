import smtplib
import ssl
import os
import json
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

message = """\
Subject: Welcome!

Welcome on openServer!
On openServer you can:
- Upload your own Applications
- Watch Film and TV Series
- Playing Music
- Upload your own Private File in the Personal Vault which you will be able to access using the credentials of your openServer Account

See you soon!

openServer Team"""

if __name__ == '__main__':
    providerSite = ""
    port = 0
    serverEmail = ""
    emailPassword = ""
    with open(os.sys.argv[1] + '/src/configs/emailProvider.json', 'r') as file:
        configs = json.load( file )
        providerSite = configs["providerSite"]
        port = configs["port"]
        serverEmail = configs["serverEmail"]
        emailPassword = configs["emailPassword"]
    context = ssl.create_default_context()
    try:
        server = smtplib.SMTP(providerSite, port)
        server.starttls(context=context)
        server.login(serverEmail, emailPassword)
        server.sendmail(serverEmail, os.sys.argv[2], message)
    except Exception as e:
        print(e)
    finally:
        server.quit()
