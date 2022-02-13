import scrapy   # noqa: F401
import snoop
import isort   # noqa: F401
from itertools import zip_longest


class SPIDER_2021(scrapy.Spider):
    name = 'spider_2021'

    start_urls = ["https://www.reddit.com/r/europe/comments/sjg6l4/after_normalisation_talks_between_turkey_and/"]

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
                   