/*const express = require('express');
const cors = require('cors');
const fetch = require('node-fetch');

const app = express();

app.use(cors());

app.get('/pumaSrap', async (req, res) => {
    const url = "https://mx.puma.com/graphql?hash=1623182739&sort_1={%22price%22:%22ASC%22}&filter_1={%22price%22:{},%22category_id%22:{%22eq%22:56},%22customer_group_id%22:{%22eq%22:%220%22}}&pageSize_1=36&currentPage_1=1&id_1=56&_currency=%22%22";
    const response = await fetch(url);
    const data = await response.json();
    res.json(data);
});

app.listen(3000, () => {
    console.log('Server started on port 3000');
});
*/


new DataTable('#table', {
    lengthChange: false,
    pageLength: 4
});

var country = "";
var country_language = "";
var marketplace = "";
var url = "";
var response = "";
var total_prods = "";
var anchor = 0;
var count = 60;
var size = 0;

async function nikeScrapper() {
    removeBorder();
    clearTable();
    $("#nike").addClass("border-info-subtle");

    country = 'mx';
    country_language = 'es-419';
    marketplace = 'MX';
    url =
        "https://api.nike.com/cic/browse/v2?queryid=products&anonymousId=00599D8669476509C2E14905CC1418B4&country=mx&endpoint=%2Fproduct_feed%2Frollup_threads%2Fv2%3Ffilter%3Dmarketplace(" +
        marketplace + ")%26filter%3Dlanguage(" + country_language +
        ")%26filter%3DemployeePrice(true)%26filter%3DattributeIds(16633190-45e5-4830-a068-232ac7aea82c%2C5b21a62a-0503-400c-8336-3ccfbff2a684)%26anchor%3D96%26consumerChannelId%3Dd9a5bc42-4b9c-4976-858a-f159cf99c647%26count%3D24&language=" +
        country_language + "&localizedRangeStr=%7BlowestPrice%7D%20%E2%80%94%20%7BhighestPrice%7D";
    response = await fetch(url);
    var data = await response.json();
    var size = data.data.products.products.length;
    total_prods = data.data.products.pages.totalResources;
    for (anchor; anchor < total_prods; anchor += 60) {
        url =
            "https://api.nike.com/cic/browse/v2?queryid=products&anonymousId=00599D8669476509C2E14905CC1418B4&country=mx&endpoint=%2Fproduct_feed%2Frollup_threads%2Fv2%3Ffilter%3Dmarketplace(" +
            marketplace + ")%26filter%3Dlanguage(" + country_language +
            ")%26filter%3DemployeePrice(true)%26filter%3DattributeIds(16633190-45e5-4830-a068-232ac7aea82c%2C5b21a62a-0503-400c-8336-3ccfbff2a684)%26anchor%3D" +
            anchor + "%26consumerChannelId%3Dd9a5bc42-4b9c-4976-858a-f159cf99c647%26count%3D24&language=" +
            country_language + "&localizedRangeStr=%7BlowestPrice%7D%20%E2%80%94%20%7BhighestPrice%7D";
        response = await fetch(url);
        data = await response.json();
        size = data.data.products.products.length;
        for (let i = 0; i < size; i++) {
            var imageURL = data.data.products.products[i].images.squarishURL;
            var name = data.data.products.products[i].title;
            var description = data.data.products.products[i].subtitle;
            var price = data.data.products.products[i].price.fullPrice;
            var total_price = data.data.products.products[i].price.currentPrice;
            var discount = (((total_price * 100) / price) - 100) * -1;
            var aux = data.data.products.products[i].url;
            aux = aux.replace("{countryLang}/", "");
            var link = "http://www.nike.com/" + country + "/" + aux;
            var t = $('#table').DataTable();
            t.row.add([
                '<img src="' + imageURL + '" alt="' + name +
                '" style="width: 100px; height: 100px;" onclick="zoomImg(this)">',
                name,
                description,
                "$" + price,
                discount.toFixed(2) + '%',
                "$" + total_price,
                '<a href="\'' + link +
                '\'" target="_blank" class="btn btn-info me-1 mb-1" type="button">Info</a>'
            ]).draw(false);
        }
    }
}

window.onload = function () {
    nikeScrapper();
}

function zoomImg(img) {
    var modal = document.getElementById("myModal");
    var modalImg = document.getElementById("img01");
    modal.style.display = "block";
    modalImg.src = img.src;
}


function clearTable() {
    var t = $('#table').DataTable();
    t.clear().draw();
}
async function adidasScrapper() {
    removeBorder();
    clearTable();
    $("#adidas").addClass("border-info-subtle");

    let count = 0;
    let size = 48; // Initial size
    let url, response, data;

    while (count < size) {
        url = "https://www.adidas.mx/api/plp/content-engine?query=calzado&sale_percentage_es_mx=30%25%7C35%25%7C40%25&start=" + count;
        response = await fetch(url);
        data = await response.json();
        size = data.raw.itemList.count; // Update size with the actual count from the response
        var items = data.raw.itemList.items;

        for (let i = 0; i < items.length; i++) {

            var imgURL = data.raw.itemList.items[i].image.src;
            var name = data.raw.itemList.items[i].displayName;
            var description = data.raw.itemList.items[i].altText;
            var price = data.raw.itemList.items[i].price;
            var wDiscount = data.raw.itemList.items[i].salePrice;
            var percent = (((wDiscount * 100) / price) - 100) * -1 ;
            var link = "https://adidas.mx" + data.raw.itemList.items[i].link;

            var t = $('#table').DataTable();

            t.row.add([
                '<img src="' + imgURL + '" alt="' + name +
                '" style="width: 100px; height: 100px;" onclick="zoomImg(this)">',
                name,
                description,
                "$" + price,
                percent.toFixed(2) + '%',
                "$" + wDiscount,
                '<a href="' + link +
                '" target="_blank" class="btn btn-info me-1 mb-1" type="button">Info</a>'
            ]).draw(false);
        }

        count += 48; // Update count after processing the current batch
    }
}

async function pumaScrapper(){
    $('.toast').toast('show');
    removeBorder();
    clearTable();
    $("#puma").addClass("border-info-subtle");
    return false;
    url = "https://mx.puma.com/graphql?hash=1623182739&sort_1={%22price%22:%22ASC%22}&filter_1={%22price%22:{},%22category_id%22:{%22eq%22:56},%22customer_group_id%22:{%22eq%22:%220%22}}&pageSize_1=36&currentPage_1=1&id_1=56&_currency=%22%22";
    response = await fetch(url);
    data = await response.json();

    var size = data.data.products.total_count;

    for( let i = 0; i < size; i++){
        var imgURL = data.data.products.items[i].thumbnail.url;
        var name = data.data.products.items[i].name;
        var description = "";
        var price = data.data.products.items[i].price_range.minimum_price.regular_price.value;
        var wDiscount = data.data.products.items[i].price_range.minimum_price.final_price.value;
        var percent = data.data.products.items[i].price_range.minimum_price.discount.percent_off;
        var link = "https://mx.puma.com/" + data.data.products.items[i].url;

        var t = $('#table').DataTable();

        t.row.add([
            '<img src="' + imgURL + '" alt="' + name +
            '" style="width: 100px; height: 100px;" onclick="zoomImg(this)">',
            name,
            description,
            "$" + price,
            percent.toFixed(2) + '%',
            "$" + wDiscount,
            '<a href="' + link +
            '" target="_blank" class="btn btn-info me-1 mb-1" type="button">Info</a>'
        ]).draw(false);
    }

    
}

function removeBorder(){
    //Removing classes to all elements with class border-info-subtle
    var elements = document.getElementsByClassName("border-info-subtle");
    for (let i = 0; i < elements.length; i++) {
        elements[i].classList.remove("border-info-subtle");
    }
}