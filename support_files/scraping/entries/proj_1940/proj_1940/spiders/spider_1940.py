import scrapy   # noqa: F401
import snoop
import isort   # noqa: F401
from itertools import zip_longest


class SPIDER_1940(scrapy.Spider):
    name = 'spider_1940'

    start_urls = ["https://www.quantamagazine.org/mathematicians-prove-30-year-old-andre-oort-conjecture-20220203/"]

    @snoop
    def parse(self, response):
        srch_titles = response.xpath("//h1/text()").getall()
        srch_links = response.xpath("//a/@href").getall()
        srch_content = response.xpath("//p/text()").getall()
        srch_images = response.xpath("//img/@src").getall()

        for item in zip_longest(srch_titles, srch_links, srch_content, srch_images, fillvalue='missing'):
            results = {
                "title": item[0],
                "links": item[1],
                "content": item[2],
                "images": item[3],
            }

            yield results
                   