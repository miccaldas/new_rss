import scrapy
# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: https://docs.scrapy.org/en/latest/topics/item-pipeline.html


# useful for handling different item types with a single interface
from itemadapter import ItemAdapter


class Proj2027Pipeline:
    def process_item(self, item, spider):

        image_urls = scrapy.Field()
        images = scrapy.Field()
        return item