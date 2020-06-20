from japronto import Application
import sys
import requests
import os
from bs4 import BeautifulSoup
import pymorphy2
from nltk.tokenize import RegexpTokenizer

tokenizer = RegexpTokenizer(r'\w+')
morph = pymorphy2.MorphAnalyzer()



def clear_text(text):
    stop = 'без,для'
    text_array = tokenizer.tokenize(text.lower())
    text_array = [morph.parse(word)[0].normal_form for word in text_array]
    res_array = []

    for word in text_array:
        if word == "":
            continue
        s = sum([1 if char.isdigit() else 0 for char in word])
        if s == 0 and len(word) > 2 and word not in stop.split(','):
            res_array.append(word)
    return res_array


def echo_service(request):
    json_data = dict()
    url = "https://www.youtube.com/api/timedtext?lang=ru&v={}".format(request.query_string)
    res = requests.get(url)
    y = BeautifulSoup(res.text, 'xml')
    titles = y.findAll("text")
    t = {}
    word_to_find = []
    cat_res = []
    for title in titles:
        words = clear_text(title.get_text())
        for w in words:
            if w in t:
                t[w] = t[w] + 1
            else:
                t[w] = 1
                word_to_find.append(w)
    return request.Response(json=t)


app = Application()
# app.router.add_route('/static/{static_file}', content_static)
# app.router.add_route('/text_to_word_sequence', text_to_word_sequence)
# app.router.add_route('/html_parsing', html_parsing_service)
# app.router.add_route('/get_features', get_features_service)
# app.router.add_route('/predict', predict_service)
app.router.add_route('/', echo_service)
app.run(debug=True)
