"""This module runs the crawl scrapy command for each project.
   In order to run the scrapy crawl command concurrently with
   a progress bar, we use the threading library."""
import glob
import os
import subprocess
import threading
import time

import isort  # noqa: F401
import snoop
from loguru import logger
from rich.progress import Progress

fmt = "{time} - {name} - {level} - {message}"
logger.add("../logs/info.log", level="INFO", format=fmt, backtrace=True, diagnose=True)  # noqa: E501
logger.add("../logs/error.log", level="ERROR", format=fmt, backtrace=True, diagnose=True)  # noqa: E501

subprocess.run(["isort", __file__])


# @logger.catch
# @snoop
def crawl_spider():
    """We first extract the spider name from its filename and run
    the command to crawl the page."""

    os.chdir("entries/")
    folder_list = next(os.walk("."))[1]
    for folder in folder_list:
        os.chdir(f"{folder}/{folder}/spiders/")
        spider_tit = glob.glob("spider*")  # Gets the spider name with just the initial characters.
        spi = " "
        spistr = spi.join(spider_tit)
        spider_title = spistr[:-3]
        os.chdir("../../")
        cmd = f"scrapy crawl {spider_title} -o results.json"
        subprocess.run(cmd, shell=True)
        os.chdir("../")


def tracker():
    """Creates a progress bar to gauge the evolution
    of the last function."""

    with Progress() as progress:
        task = progress.add_task("[#F76E11]Processing...", total=160)
        while not progress.finished:
            progress.update(task, advance=1)
            time.sleep(3)


if __name__ == "__main__":
    t1 = threading.Thread(target=crawl_spider)
    t2 = threading.Thread(target=tracker)
    t1.start()
    t2.start()
    t1.join()
    t2.join()
