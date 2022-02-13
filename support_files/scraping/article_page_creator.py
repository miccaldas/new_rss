"""This module creates a php page with article content, title and link."""
import os
import shutil
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
def article_page_creator():
    """Opens a file and writes the content to it."""

    os.chdir("entries/")
    folder_list = next(os.walk("."))[1]
    for fldr in folder_list:
        os.chdir(fldr)
        ident = fldr[-4:]
        try:
            conn = connect(host="localhost", user="mic", password="xxxx", database="rss")
            cur = conn.cursor()
            cur.execute("SELECT title, link FROM rss WHERE id = " + ident)
            rows = cur.fetchall()
            for row in rows:
                with open(f"{fldr}.php", "w") as f:
                    f.write(
                        """<!DOCTYPE html>
                                <html lang="en">
                                <head>"""
                    )
                    f.write("<br>")
                    f.write("<title>")
                    f.write(f"{row[0]}")
                    f.write("</title><br>")
                    f.write(
                        """<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Mclds">
  <meta name="description" content="page">
  <meta property="og:title" content=''>
  <meta property="og:type" content="web page">
  <meta property="og:url" content="">
  <meta property="og:image" content="../img/sun_symbol-512x512.png">
  <link rel="manifest" href="site.webmanifest">
  <link rel="stylesheet" type="text/css" href="http://localhost/poems_folding_menu/css/index.css" media="screen">
  <link rel="stylesheet" type="text/css" href="http://localhost/poems_folding_menu/css/tachyons.css" media="screen">
  <style>
    p {
        margin-bottom: -1em;
  }
  </style>
</head>
<body class="vh-100 pa0 ma0 sans-serif avenir next f4 fw6 dark-gray bg-near-white">
  <div id="page_container" class="relative min-h-100 overflow-hidden db">
    <div id="content_wrap" class="pb3">
      <div id="top-spacer" class="h4 mt0.5 mb4"></div>
      <div id="flex-container" class="flex mt=2 mb=2">
        <div id="col1" class="flex-row items-center self-center justify-center content-center w-10 order-0"></div>
        <div id="col2" class="flex-row items-center self-center justify-center content-center w-80 order-1 mb4">"""
                    )
                    f.write("<br>")
                    f.write(f"<h1>{row[0]}</h1><br>")
                    f.write(f"<?php require '/usr/share/nginx/html/new_rss/support_files/scraping/entries/{fldr}/content.php'; ?>")
                    f.write(f"<br><a href='{row[1]}'>LINK</a>")
                    f.write(
                        """ </div>
        <div id="col3" class="flex-row items-center self-center justify-center content-center w-10 order-2"></div>
      </div>
    </div><?php include '/usr/share/nginx/html/support_services/partials/footer.php'; ?>
  </div>
  <script src="/new_rss/support_files/js/vendor/modernizr-3.11.2.min.js"></script>
  <script src="/new_rss/support_files/js/plugins.js"></script>
  <script src="/new_rss/support_files/js/main.js"></script>
</body>
</html>"""
                    )
            shutil.move(f"{fldr}.php", f"/usr/share/nginx/html/new_rss/pages/{fldr}.php")
            os.chdir("../")
        except Error as e:
            print("Error while connecting to db", e)
        finally:
            if conn:
                conn.close()


if __name__ == "__main__":
    article_page_creator()
