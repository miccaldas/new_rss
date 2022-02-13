import scrapy   # noqa: F401
import snoop
import isort   # noqa: F401
from itertools import zip_longest


class SPIDER_2018(scrapy.Spider):
    name = 'spider_2018'

    start_urls = ["https://www.reddit.com/r/europe/comments/sjd2uu/in_the_byzantine_times_monks_had_the_inspiration/"]

    @snoop
    def parse(self, response):
        srch_titles = response.xpath('//h1/text()').get()
        srch_links = response.xpath('//a[@href]').getall()
        srch_content = response.xpath("//p/text()").getall()

        for item in zip_longest(srch_titles, srch_links, srch_content, fillvalue='missing'):
            results = {
                "title": item[0],
                "links": item[1],
                "content": item[2],
            }

            yield results
                   