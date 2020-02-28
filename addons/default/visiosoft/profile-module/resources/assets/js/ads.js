var current_page = 1;
var records_per_page = ads_per_page;
var ads_type = "";

var objJson = [];

function prevPage()
{
    if (current_page > 1) {
        current_page--;
        changePage(current_page);
    }
}

function nextPage(event)
{
    if (current_page < numPages()) {
        current_page++;
        changePage(current_page);
    }
}

function changePage(page)
{
    var btn_next = $("#btn_next");
    var btn_prev = $("#btn_prev");
    var listing_table = $("#nav-" + ads_type);
    var page_span = $("#page");

    // Validate page
    if (page < 1) page = 1;
    if (page > numPages()) page = numPages();

    listing_table.html("");

    for (var i = (page-1) * records_per_page; i < (page * records_per_page) && i < objJson.length; i++) {
        listing_table.append(addAdsRow(objJson[i].id, objJson[i].detail_url, objJson[i].cover_photo, objJson[i].name,
            objJson[i].price + " " + objJson[i].currency,
            objJson[i].city_name, objJson[i].country_name, objJson[i].cat1_name, objJson[i].cat2_name, objJson[i].status));
    }

    page_span.html(page + "/" + numPages());

    if (numPages() === 1) {
        page_span.hide();
    } else {
        page_span.show();
    }

    if (page === 1) {
        btn_prev.hide();
    } else {
        btn_prev.show();
    }

    if (page === numPages()) {
        btn_next.hide();
    } else {
        btn_next.show();
    }
}

function numPages()
{
    return Math.ceil(objJson.length / records_per_page);
}

function crud(params, url, type, callback) {
    $.ajax({
        type: type,
        data: params,
        url: url,
        success: function (response) {
            callback(response);
        },
    });
}

function getMyAds(type) {
    crud({'type': type}, '/ajax/getAds', 'GET', function (callback) {
        ads_type = type;
        current_page = 1;
        objJson = callback.content;
        changePage(1);
    })
}

$('.profile-ads-tab a').on('click', function () {
    getMyAds($(this).attr('data-type'))
});

getMyAds('approved');


function addAdsRow(id, href, image, name, price, city, country, cat1, cat2, status) {
    return "<div class='col-md-12 mb-2 profile-ads border-bottom border-white'>\n" +
        "<div class='row bg-light'>\n" +
        "<div class='col-md-2 justify-content-center align-self-center border-right border-white'>\n" +
        "<img class='img-thumbnail' src='" + image + "' alt='" + name + "'>\n" +
        "</div>\n" +
        "<div class='col-md-7 justify-content-center align-self-center border-right border-white'>\n" +
        "<div class='row'>\n" +
        "<div class='col-md-10'>\n" +
        "<a href='" + href + "' class='text-dark'>\n" +
        "<p>" + name + "</p>\n</a>" +
        "</div>\n" +
        "<div class='col-md-2 text-right'>\n" +
        dropdownRow(id, status) +
        "</div>\n" +
        "<div class='col-md-12 text-truncate'>\n" +
        "<small class='text-muted'>" + cat1 + ", " + cat2 + "</small>\n" +
        "</div>\n" +
        "</div>\n" +
        "</div>\n" +
        "<div class='col-md-3 text-left justify-content-center align-self-center'>\n" +
        "<div class='row'>\n" +
        "<div class='col-md-12'>\n" +
        "<b>" + price + "</b>\n" +
        "</div>\n" +
        "<div class='col-md-12 justify-content-center align-self-center text-truncate'>\n" +
        "<small>" + city + " " + country + "</small>\n" +
        "</div>\n</div>\n</div>\n</div>\n\n</div>";
}

function dropdownRow(id, type) {
    var dropdown = "<div class='dropdown'>\n" +
        "  <button class='dropdown-toggle btn btn-outline-dark' type='button' id='dropdownMenuButton' data-toggle='dropdown'>\n" +
        "<i class=\"fas fa-ellipsis-v\"></i>" +
        "  </button>\n" +
        "  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>\n";
    if (type == "passive") {
        dropdown += "<a class='dropdown-item text-success' href='/advs/status/" + id + ",approved'>" +
            "<i class='fas fa-eye'></i> " +
            approve +
            "</a>\n";
    } else {
        dropdown += "<a class='dropdown-item text-secondary' href='/advs/status/" + id + ",passive'>" +
            "<i class='fas fa-eye-slash'></i> " +
            passive +
            "</a>\n";
    }

    dropdown += "<a class='dropdown-item text-primary' href='/advs/edit_advs/" + id + "'>" +
        "<i class='fas fa-pencil-alt'></i> " +
        edit_ad +
        "</a>\n";

    dropdown += "<a class='dropdown-item text-danger' href='/advs/delete/" + id + "'>" +
        "<i class='fas fa-trash'></i> " +
        delete_ad +
        "</a>\n";

    dropdown += "<a class='dropdown-item text-info' href='/advs/extend/" + id + "'>" +
        "<i class='fas fa-calendar'></i> " +
        extend_ad +
        "</a>\n";

    dropdown += "</div></div>";
    return dropdown;

}



