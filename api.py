import requests
from bs4 import BeautifulSoup
import certifi
import os
import sys
import json

os.environ['REQUESTS_CA_BUNDLE'] = certifi.where()
query = sys.argv[1]
# query = 'python'
url = f"https://library.shooliniuniversity.com/cgi-bin/koha/opac-search.pl?q={query}"

req= requests.get(url, verify=False)

if req.status_code == 200:
    soup= BeautifulSoup(req.content, "html.parser")

    # print(soup.prettify())

    books=[]  # a list to store quotes 
    
    table = soup.find('table', attrs = {'class':'table table-striped'})  
    
    for row in table.find_all('tr'):
        # find all <td> tags within current <tr> tag]
        cells = row.find_all('td', attrs={'class':'bibliocol'})
        
        for cell in cells: 
            # print(cell.text.strip()) 
            a_tag = cell.find('a', class_='p1')
            title_a_tag = cell.find('a', class_='title')
            author_span = cell.find('span', class_='author')
            publisher_span = cell.find('span', class_='results_summary publisher')
            availability_span = cell.find('span', class_='results_summary availability')
            
            book = {} 
            
            book["link"] = 'https://library.shooliniuniversity.com/'+a_tag.get('href')       
            book["title"] = title_a_tag.text.strip()
            book["author"] = author_span.text.strip()
            book["publisher"] = publisher_span.text.strip()
            book["availability"] = availability_span.text.strip() 
            
            # print("Link: ", book['link'])
            # print("Title: ", book['title'])
            # print("Author: ", book['author'])
            # print("Publisher: ", book['publisher'])
            # print("Availability: ", book['availability'])
            
            books.append(book)
    json_books = json.dumps(books)
    print(json_books)
    
            
else:
    print("Failed to retrieve the webpage: ", req.status_code)
   
