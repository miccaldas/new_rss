"""Creates the content for the homepage."""
import os
import subprocess

import isort  # noqa: F401
import snoop
from loguru import logger
from mysql.connector import Error, connect

fmt = "{time} - {name} - {level} - {message}"
logger.add("../logs/info.log", level="INFO", format=fmt, backtrace=True, diagnose=True)  # noqa: E501
logger.add("../logs/error.log", level="ERROR", format=fmt, backtrace=True, diagnose=True)  # noqa: E501

subprocess.run(["isort", __file__])


@logger.catch
@snoop
def index_page_creator():
    """Takes the title value from the database and inserts a
    link on it."""

    os.chdir("/usr/share/nginx/html/new_rss/pages")
    for filename in os.listdir("./"):
        ident = filename[5:-4]
        try:
            conn = connect(host="localhost", user="mic", password="xxxx", database="rss")
            cur = conn.cursor()
            cur.execute("SELECT title FROM rss WHERE id = " + ident)
            rows = cur.fetchall()
            for row in rows:
                with open("article_list.php", "a") as f:
                    f.write(f"<a href='{filename}'>{row[0]}</a><br>")
        except Error as e:
            print("Error while connecting to db", e)
        finally:
            if conn:
                conn.close()


if __name__ == "__main__":
    index_page_creator()
