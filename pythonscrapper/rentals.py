import requests
from bs4 import BeautifulSoup
from selenium import webdriver
import pymysql
import json

def textskin(text):
    return text.replace("'","@@@").replace('"','###')

def find_index(str1, substring):
    l2 = []
    length = len(str1)
    index = 0
    while index < length:
        x = str1.find(substring, index)
        if x == -1:
            return l2
        l2.append(x)
        index = x + 1
    return l2

def rentals_info(url, page_name):
    page = requests.get(url)
    soup = BeautifulSoup(page.content, "html.parser")
    # f = open("rentals/"+page_name, "w+", encoding='utf-8')
    # f.write(str(soup))
    # f.close()
    
    page_content = soup.find('div', attrs={'id':'pop3'})
    product_info = page_content.find_all('a')
    # for i in range(len(product_info)):
    for i in range(len(product_info)):
        product_url = 'https://www.simonmamo.com/' + product_info[i].get('href')
        print(str(i) + " product_url: " + product_url)
        # print(str(product_info))
        try:
            pre = product_info[i].find('pre').text
            item_id_first = pre.find('\n    [id] => ') + len('\n    [id] => ')
            if pre.find('\n    [id] => ') != -1:
                item_id_end = pre.find('\n', item_id_first, len(pre))
                item_id = pre[item_id_first:item_id_end]
            else:
                item_id = ''
            print('item_id: ' + item_id)

            create_date_first = pre.find('\n    [create_date] => ') + len('\n    [create_date] => ')
            if pre.find('\n    [create_date] => ') != -1:
                create_date_last = pre.find('\n', create_date_first, len(pre))
                create_date = pre[create_date_first:create_date_last]
            else:
                create_date = ''
            print('create_date: ' + create_date)

            modified_date_first = pre.find('\n    [modified_date] => ') + len('\n    [modified_date] => ')
            if pre.find('\n    [modified_date] => ') != -1:
                modified_date_last = pre.find('\n', modified_date_first, len(pre))
                modified_date = pre[modified_date_first:modified_date_last]
            else:
                modified_date = ''
            print('modified_date: ' + modified_date)

            publish_date_first = pre.find('\n    [publish_date] => ') + len('\n    [publish_date] => ')
            if pre.find('\n    [publish_date] => ') != -1:
                publish_date_last = pre.find('\n', publish_date_first, len(pre))
                publish_date = pre[publish_date_first:publish_date_last]
            else:
                publish_date = ''
            print('publish_date: ' + publish_date)

            archive_date_first = pre.find('\n    [archive_date] => ') + len('\n    [archive_date] => ')
            if pre.find('\n    [archive_date] => ') != -1:
                archive_date_last = pre.find('\n', archive_date_first, len(pre))
                archive_date = pre[archive_date_first:archive_date_last]
            else:
                archive_date = ''
            print('archive_date: ' + archive_date)

            commercial_first = pre.find('\n    [commercial] => ') + len('\n    [commercial] => ')
            if pre.find('\n    [commercial] => ') != -1:
                commercial_last = pre.find('\n', commercial_first, len(pre))
                commercial = pre[commercial_first:commercial_last]
            else:
                commercial = ''
            print('commercial: ' + commercial)

            sale_price_first = pre.find('\n    [propertyforsaleprice] => ') + len('\n    [propertyforsaleprice] => ')
            if pre.find('\n    [propertyforsaleprice] => ') != -1:
                sale_price_last = pre.find('\n', sale_price_first, len(pre))
                sale_price = pre[sale_price_first:sale_price_last]
            else:
                sale_price = ''
            print('sale_price: ' + sale_price)

            rent_price_first = pre.find('\n    [slongletprice] => ') + len('\n    [slongletprice] => ')
            if pre.find('\n    [slongletprice] => ') != -1:
                rent_price_last = pre.find('\n', rent_price_first, len(pre))
                rent_price = pre[rent_price_first:rent_price_last]
            else:
                rent_price = ''
            print('rent_price: ' + rent_price)

            location_first = pre.find('\n    [location] => ') + len('\n    [location] => ')
            if pre.find('\n    [location] => ') != -1:
                location_last = pre.find('\n', location_first, len(pre))
                location = pre[location_first:location_last]
            else:
                location = ''
            print('location: ' + location)

            bedrooms_first = pre.find('\n    [bedrooms] => ') + len('\n    [bedrooms] => ')
            if pre.find('\n    [bedrooms] => ') != -1:
                bedrooms_last = pre.find('\n', bedrooms_first, len(pre))
                bedrooms = pre[bedrooms_first:bedrooms_last]
            else:
                bedrooms = ''
            print('bedrooms: ' + bedrooms)

            bathrooms_first = pre.find('\n    [bathrooms] => ') + len('\n    [bathrooms] => ')
            if pre.find('\n    [bathrooms] => ') != -1:
                bathrooms_last = pre.find('\n', bathrooms_first, len(pre))
                bathrooms = pre[bathrooms_first:bathrooms_last]
            else:
                bathrooms = ''
            print('bathrooms: ' + bathrooms)

            area_first = pre.find('\n    [area] => ') + len('\n    [area] => ')
            if pre.find('\n    [area] => ') != -1:
                area_last = pre.find('\n', area_first, len(pre))
                area = pre[area_first:area_last]
            else:
                area = ''
            print('area: ' + area)

            address_first = pre.find('\n    [address] =>  ') + len('\n    [address] =>  ')
            if pre.find('\n    [address] =>  ') != -1:
                address_last = pre.find('\n', address_first, len(pre))
                address = pre[address_first:address_last]
            else:
                address = ''
            print('address: ' + address)

            directions_first = pre.find('\n    [directions] => ') + len('\n    [directions] => ')
            if pre.find('\n    [directions] => ') != -1:
                directions_last = pre.find('\n', directions_first, len(pre))
                directions = pre[directions_first:directions_last]
            else:
                directions = ''
            print('directions: ' + directions)

            owner_id_first = pre.find('\n    [owner] => ') + len('\n    [owner] => ')
            if pre.find('\n    [owner] => ') != -1:
                owner_id_last = pre.find('\n', owner_id_first, len(pre))
                owner_id = pre[owner_id_first:owner_id_last]
            else:
                owner_id = ''
            print('owner_id: ' + owner_id)

            ownername_first = pre.find('\n    [ownername] => ') + len('\n    [ownername] => ')
            if pre.find('\n    [ownername] => ') != -1:
                ownername_last = pre.find('\n', ownername_first, len(pre))
                ownername = pre[ownername_first:ownername_last]
            else:
                ownername = ''
            print('ownername: ' + ownername)

            mobile_first = pre.find('\n    [mobile] => ') + len('\n    [mobile] => ')
            if pre.find('\n    [mobile] => ') != -1:
                mobile_last = pre.find('\n', mobile_first, len(pre))
                mobile = pre[mobile_first:mobile_last]
            else:
                mobile = ''
            print('mobile: ' + mobile)

            title_first = pre.find('\n    [name] => ') + len('\n    [name] => ')
            if pre.find('\n    [name] => ') != -1:
                title_last = pre.find('\n', title_first, len(pre))
                title = pre[title_first:title_last]
            else:
                title = ''
            print('title: ' + title)

            description_first = pre.find('\n    [description] => ') + len('\n    [description] => ')
            if pre.find('\n    [description] => ') != -1:
                description_last = pre.find('\n    [images] ', description_first, len(pre))
                description = pre[description_first:description_last]
            else:
                description = ''
            print('description: ' + description)

            note_temp_first = pre.find('[notes] => stdClass Object') + len('[notes] => stdClass Object')
            if pre.find('[notes] => stdClass Object') != -1:
                note_temp = pre[note_temp_first:len(pre)]
                notes_first = note_temp.find('[rawvalue] => ') + len('[rawvalue] => ')
                if note_temp.find('[rawvalue] => ') != -1:
                    notes_last = note_temp.find('\n', notes_first, len(note_temp))
                    notes = note_temp[notes_first:notes_last]
                else:
                    notes = ''
            else:
                notes = ''
            print('notes: ' + notes)

            category_temp_first = pre.find('[categories] => Array') + len('[categories] => Array')
            if pre.find('[categories] => Array') != -1:
                category_temp_last = pre.find('\n        )', category_temp_first, len(pre))
                category_temp = pre[category_temp_first:category_temp_last]
                category_first_all = find_index(category_temp, '\n                    [name] => ')
                if len(category_first_all) != 0:
                    for i in range(len(category_first_all)):
                        category_first = category_first_all[i] + len('\n                    [name] => ')
                        category_last = category_temp.find('\n', category_first, len(category_temp))
                        if i == 0:
                            category = category_temp[category_first:category_last]
                        else:
                            category = category + ',' + category_temp[category_first:category_last]
                else:
                    category = ''
            else:
                category = ''
            print('category: ' + category)
        except:
            pre = ""
            item_id = ''
            create_date = ''
            modified_date = ''
            publish_date = ''
            archive_date = ''
            commercial = ''
            sale_price = ''
            rent_price = ''
            location = ''
            bedrooms = ''
            bathrooms = ''
            area = ''
            address = ''
            directions = ''
            owner_id = ''
            ownername = ''
            mobile = ''
            title = ''
            description = ''
            notes = ''
            category = ''
            try:
                item_id = product_info[i].find('div', attrs={'class':'pp-ref sbold'}).text
                item_id = item_id.replace("Ref No: ", '')
            except:
                item_id = ''
            try:
                title = product_info[i].find('h3', attrs={'class':'pp-name sbold'}).text
            except:
                title = ''
            try:
                description = product_info[i].find('div', attrs={'class':'pp-desc'}).text
                description = description.replace('Description','')
            except:
                description = ''
        commercial = textskin(commercial)
        location = textskin(location)
        area = textskin(area)
        address = textskin(address)
        directions = textskin(directions)
        ownername = textskin(ownername)
        title = textskin(title)
        description = textskin(description)
        notes = textskin(notes)
        category = textskin(category)
        product_url = textskin(product_url)
        listing_type = 'Rental'
        sql = "INSERT INTO `listing`(`item_id`, `url`, `create_date`, `modified_date`, `publish_date`, `archive_date`, `commercial`, `category`, `sale_price`, `rent_price`, `title`, `location`, `bedrooms`, `bathrooms`, `area`, `address`, `directions`, `owner_id`, `ownername`, `mobile`, `notes`, `description`, `type`) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')" % (item_id, product_url, create_date, modified_date, publish_date, archive_date, commercial, category, sale_price, rent_price, title, location, bedrooms, bathrooms, area, address, directions, owner_id, ownername, mobile, notes, description, listing_type)
        try:
            # Execute the SQL command
            cursor.execute(sql)
            # Commit your changes in the database
            db.commit()
        except:
            # Rollback in case there is any error
            db.rollback()
    
    f = open("rentals/"+page_name, "w+", encoding='utf-8')
    f.write(str(soup))
    f.close()


# Open database connection
db = pymysql.connect("localhost","root","","simonmamo" )

# prepare a cursor object using cursor() method
cursor = db.cursor()

# rentals_info("https://www.simonmamo.com/en/property-forsale/webshop/search/item/propertyforsaleprice/desc/20/8.htm?region=Select&as-minp=0&asm-axp=&beds=&condition=", "rentals8.html")

for i in range(1, 745):
    rentals_url = 'https://www.simonmamo.com/en/home/webshop/search/item/publish_date/desc/20/' + str(i) + '.htm?listingtype=longlet&selectItemlistingtype=longlet&selectGrouptype%255B%255D=&selectGrouptype%255B%255D=&date_from=&beds=Any&selectItembeds=Any'
    page_name = "rentals" + str(i) +".html"
    rentals_info(rentals_url, page_name)

db.close()