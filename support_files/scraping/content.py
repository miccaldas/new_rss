"""This module takes all entries in the content tag and puts them in a file."""
import json
import os
import subprocess

import isort  # noqa: F401
import snoop
from loguru import logger

fmt = "{time} - {name} - {level} - {message}"
logger.add("../logs/info.log", level="INFO", format=fmt, backtrace=True, diagnose=True)  # noqa: E501
logger.add("../logs/error.log", level="ERROR", format=fmt, backtrace=True, diagnose=True)  # noqa: E501

subprocess.run(["isort", __file__])


@logger.catch
@snoop
def content():
    """We'll go to each scrapy folder and source all content
    that is different than missing. We then put it in a text file."""

    os.chdir("entries/")
    folder_list = next(os.walk("."))[1]
    for fldr in folder_list:
        os.chdir(fldr)
        with open("results.json") as f:
            content = json.load(f)

        for i in content:
            if i["content"] != "missing":
                with open("content.html", "a") as f:
                    f.write(i["content"])
        os.chdir("../")


if __name__ == "__main__":
    content()
