import scrapy   # noqa: F401
import snoop
import isort   # noqa: F401
from itertools import zip_longest


class SPIDER_1999(scrapy.Spider):
    name = 'spider_1999'

    start_urls = ["https://www.reddit.com/r/linux/comments/sirees/improve_desktop_application_and_game_performance/"]

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
                   