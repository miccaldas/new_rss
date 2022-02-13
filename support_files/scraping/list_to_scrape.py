"""This module will call the rss db and download all entries that are newer that the last time such
   a request was made."""
import os
import subprocess

import isort  # noqa: F401
import snoop
from loguru import logger
from mysql.connector import Error, connect
from scrapy_project_class import ScrapyProject
from scrapy_project_linuxjournal import ScrapyProjectJournal
from scrapy_project_quanta import ScrapyProjectQuanta
from scrapy_project_reddit import ScrapyProjectReddit
from scrapy_project_slashdot import ScrapyProjectSlashdot

fmt = "{time} - {name} - {level} - {message}"
logger.add("../logs/info.log", level="INFO", format=fmt, backtrace=True, diagnose=True)
logger.add("../logs/error.log", level="ERROR", format=fmt, backtrace=True, diagnose=True)

subprocess.run(["isort", __file__])


@logger.catch
@snoop
def list_to_scrape():
    """Downloads the db to a list."""

    conn = connect(host="localhost", user="mic", password="xxxx", database="rss")
    cur = conn.cursor()
    inserir = "SELECT * FROM rss;"
    cur.execute(
        inserir,
    ),
    rows = cur.fetchall()
    return rows


if __name__ == "__main__":
    list_to_scrape()


@logger.catch
@snoop
def scrape():
    """For each publication from the feeds, we'll create a scraping folder to get its information."""

    rows = list_to_scrape()

    for row in rows:
        domain = f'"{row[3]}"'
        project_name = f"proj_{str(row[0])}"
        spider_name = f"spider_{str(row[0])}"
        if row[1] == "Lobsters":

            scr = ScrapyProject(project_name, spider_name, domain)
            scr.project_creation()
            scr.settings_definition()
            scr.spider()

        if row[1] == "Quanta Magazine":

            scr = ScrapyProjectQuanta(project_name, spider_name, domain)
            scr.project_creation()
            scr.settings_definition()
            scr.spider()

        if row[1] == "Linux Journal - The Original Magazine of the Linux Community":

            scr = ScrapyProjectJournal(project_name, spider_name, domain)
            scr.project_creation()
            scr.settings_definition()
            scr.spider()

        if row[1] == "Slashdot: Linux":

            scr = ScrapyProjectSlashdot(project_name, spider_name, domain)
            scr.project_creation()
            scr.settings_definition()
            scr.spider()

        if row[1] == "Europe":

            scr = ScrapyProjectReddit(project_name, spider_name, domain)
            scr.project_creation()
            scr.settings_definition()
            scr.spider()

        if row[1] == "Linux, GNU/Linux, free software...":

            scr = ScrapyProjectReddit(project_name, spider_name, domain)
            scr.project_creation()
            scr.settings_definition()
            scr.spider()

        if row[1] == "Command Line":

            scr = ScrapyProjectReddit(project_name, spider_name, domain)
            scr.project_creation()
            scr.settings_definition()
            scr.spider()

        if row[1] == "Hacker News":

            scr = ScrapyProject(project_name, spider_name, domain)
            scr.project_creation()
            scr.settings_definition()
            scr.spider()


if __name__ == "__main__":
    scrape()
