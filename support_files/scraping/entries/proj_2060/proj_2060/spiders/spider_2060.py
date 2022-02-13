import scrapy   # noqa: F401
import snoop
import isort   # noqa: F401
from itertools import zip_longest


class SPIDER_2060(scrapy.Spider):
    name = 'spider_2060'

    start_urls = ["https://www.quantamagazine.org/secrets-of-early-animal-evolution-revealed-by-chromosome-tectonics-20220202/"]
    @snoop
    def parse(self, response):
        srch_titles = response.xpath("//h1/text()").getall()
        srch_links = response.xpath("//a/@href").getall()
        srch_content = response.xpath("//p/text()").getall()
        srch_images = response.xpath("//*[@id='postBody']/figure/div/div/div/div/figure/div/div[1]/video").getall()

        for item in zip_longest(srch_titles, srch_links, srch_content, srch_images, fillvalue='missing'):
            results = {
                "title": item[0],
                "links": item[1],
                "content": item[2],
                "images": item[3],
            }

            yield results
                   