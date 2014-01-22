#DB_HOST = 'hal9000'
#DB_USER = 'schudoma'
#DB_PASS = 'passwordpasswor'
#DB_NAME = 'trost_prod'

#DB_HOST = 'localhost'
#DB_USER = 'root'
#DB_PASS = 'password'
#DB_NAME = 'trost_prod_reimport'

DB_HOST = 'cosmos'
DB_USER = 'billiau'
DB_PASS = 'password'
DB_NAME = 'trost_prod'

#DB_HOST = 'hal9000'
#DB_USER = 'billiau'
#DB_PASS = 'password'
#DB_NAME = 'trost_prod'

def get_db(db_name=None):
    import MySQLdb
    if db_name is None: db_name = DB_NAME
    return MySQLdb.connect(host=DB_HOST,
                          user=DB_USER,
                          passwd=DB_PASS,
                          db=db_name,
                          charset='utf8',
                          init_command='SET NAMES UTF8')

def get_ora_db():
    import cx_Oracle
    #conn = cx_Oracle.Connection('lims_read/jsbach@141.14.246.128:1521/naut90.mpimp-golm.mpg.de')
    #conn = cx_Oracle.Connection('TROST_USER/kartoffel@141.14.246.128:1521/naut81.mpimp-golm.mpg.de')
    conn = cx_Oracle.Connection('lims_read/jsbach@limsdb2/naut90.mpimp-golm.mpg.de')
    conn.current_schema = 'LIMS';

    return conn
