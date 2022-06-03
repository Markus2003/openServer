import yagmail
import os
import json

if __name__ == '__main__':
    with open(os.sys.argv[1] + '/src/API/python/email.json', 'r' ) as file:
        text = json.load( file )
        try:
            yag = yagmail.SMTP( text['sender'], oauth2_file=str(os.sys.argv[1] + '/src/configs/oauth2_creds.json') )
            yag.send( os.sys.argv[2], text[os.sys.argv[3]][0], text[os.sys.argv[3]][1] )
        except Exception as e:
	        pass
