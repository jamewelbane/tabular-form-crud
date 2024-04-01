function sortColumn(column) {
    var currentUrl = window.location.href;
    var sortParam = 'sort=' + column;
    var ascendingOrderParam = 'order=asc';
    var descendingOrderParam = 'order=desc';

    // Remove existing sorting parameters from the URL
    currentUrl = currentUrl.replace(/[?&]sort=[^&]*/g, '').replace(/[?&]order=[^&]*/g, '');

    // Add new sorting parameters to the URL
    var sortUrl = currentUrl;
    if (sortUrl.includes('?')) {
        sortUrl += '&';
    } else {
        sortUrl += '?';
    }
    sortUrl += sortParam + '&' + ascendingOrderParam;

    // Redirect to the sorted URL
    window.location.href = sortUrl;

    // Update caret icon class
    var iconClass = 'fas fa-caret-up';
    document.querySelector('th.' + column + ' i').className = iconClass;
}


function sortColumnDesc(column) {
    var currentUrl = window.location.href;
    var sortParam = 'sort=' + column;
    var descendingOrderParam = 'order=desc';


    currentUrl = currentUrl.replace(/[?&]sort=[^&]*/g, '').replace(/[?&]order=[^&]*/g, '');


    var sortUrl = currentUrl;
    if (sortUrl.includes('?')) {
        sortUrl += '&';
    } else {
        sortUrl += '?';
    }
    sortUrl += sortParam + '&' + descendingOrderParam;


    window.location.href = sortUrl;


    var iconClass = 'fas fa-caret-up';
    document.querySelector('th.' + column + ' i').className = iconClass;
}