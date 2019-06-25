'use strict';
$('#js-grid-juicy-projects').cubeportfolio({
    filters: '#js-filters-juicy-projects',
    loadMore: '#js-loadMore-juicy-projects',
    loadMoreAction: 'click',
    layoutMode: 'grid',
    defaultFilter: '*',
    animationType: 'quicksand',
    gapHorizontal: 35,
    gapVertical: 30,
    gridAdjustment: 'responsive',
    mediaQueries: [{
        width: 1500,
        cols: 5
    }, {
        width: 1100,
        cols: 4
    }, {
        width: 800,
        cols: 3
    }, {
        width: 480,
        cols: 2
    }, {
        width: 320,
        cols: 1
    }],
    caption: 'overlayBottomReveal',
    displayType: 'sequentially',
    displayTypeSpeed: 80,

    // lightbox
    lightboxDelegate: '.cbp-lightbox',
    lightboxGallery: true,
    lightboxTitleSrc: 'data-title',
    lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',


});
$('#js-grid-juicy-projects2').cubeportfolio({
    filters: '#js-filters-juicy-projects2',
    loadMore: '#js-loadMore-juicy-projects2',
    loadMoreAction: 'click',
    layoutMode: 'grid',
    defaultFilter: '*',
    animationType: 'quicksand',
    gapHorizontal: 35,
    gapVertical: 30,
    gridAdjustment: 'responsive',
    mediaQueries: [{
        width: 1500,
        cols: 5
    }, {
        width: 1100,
        cols: 4
    }, {
        width: 800,
        cols: 3
    }, {
        width: 480,
        cols: 2
    }, {
        width: 320,
        cols: 1
    }],
    caption: 'overlayBottomReveal',
    displayType: 'sequentially',
    displayTypeSpeed: 80,

    // lightbox
    lightboxDelegate: '.cbp-lightbox',
    lightboxGallery: true,
    lightboxTitleSrc: 'data-title',
    lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',

    // singlePage popup
    singlePageDelegate: '.cbp-singlePage',
    singlePageDeeplinking: true,
    singlePageStickyNavigation: true,
    singlePageCounter: '<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',

     });
$('#js-grid-juicy-projects3').cubeportfolio({
    filters: '#js-filters-juicy-projects3',
    loadMore: '#js-loadMore-juicy-projects3',
    loadMoreAction: 'click',
    layoutMode: 'grid',
    defaultFilter: '*',
    animationType: 'quicksand',
    gapHorizontal: 35,
    gapVertical: 30,
    gridAdjustment: 'responsive',
    mediaQueries: [{
        width: 1500,
        cols: 5
    }, {
        width: 1100,
        cols: 4
    }, {
        width: 800,
        cols: 3
    }, {
        width: 480,
        cols: 2
    }, {
        width: 320,
        cols: 1
    }],
    caption: 'overlayBottomReveal',
    displayType: 'sequentially',
    displayTypeSpeed: 80,

    // lightbox
    lightboxDelegate: '.cbp-lightbox',
    lightboxGallery: true,
    lightboxTitleSrc: 'data-title',
    lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',


});

$("a[data-toggle=\"tab\"]").on("shown.bs.tab", function (e) {
   // (function ($, window, document, undefined) {

    jQuery("#js-grid-juicy-projects").cubeportfolio('destroy');jQuery("#js-grid-juicy-projects3").cubeportfolio('destroy');jQuery("#js-grid-juicy-projects2").cubeportfolio('destroy');

        // init cubeportfolio
    'use strict';
    $('#js-grid-juicy-projects').cubeportfolio({
        filters: '#js-filters-juicy-projects',
        loadMore: '#js-loadMore-juicy-projects',
        loadMoreAction: 'click',
        layoutMode: 'grid',
        defaultFilter: '*',
        animationType: 'quicksand',
        gapHorizontal: 35,
        gapVertical: 30,
        gridAdjustment: 'responsive',
        mediaQueries: [{
            width: 1500,
            cols: 5
        }, {
            width: 1100,
            cols: 4
        }, {
            width: 800,
            cols: 3
        }, {
            width: 480,
            cols: 2
        }, {
            width: 320,
            cols: 1
        }],
        caption: 'overlayBottomReveal',
        displayType: 'sequentially',
        displayTypeSpeed: 80,

        // lightbox
        lightboxDelegate: '.cbp-lightbox',
        lightboxGallery: true,
        lightboxTitleSrc: 'data-title',
        lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',

        /*singlePage popup
         singlePageDelegate: '.cbp-singlePage',
         singlePageDeeplinking: true,
         singlePageStickyNavigation: true,
         singlePageCounter: '<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',
         /*singlePageCallback: function(url, element) {
         // to update singlePage content use the following method: this.updateSinglePage(yourContent)
         var t = this;

         $.ajax({
         url: url,
         type: 'GET',
         dataType: 'html',
         timeout: 10000
         })
         .done(function(result) {
         t.updateSinglePage(result);
         })
         .fail(function() {
         t.updateSinglePage('AJAX Error! Please refresh the page!');
         });
         },*/
    });


      $('#js-grid-juicy-projects2').cubeportfolio({
            filters: '#js-filters-juicy-projects2',
            loadMore: '#js-loadMore-juicy-projects2',
            loadMoreAction: 'click',
            layoutMode: 'grid',
            defaultFilter: '*',
            animationType: 'quicksand',
            gapHorizontal: 35,
            gapVertical: 30,
            gridAdjustment: 'responsive',
            mediaQueries: [{
                width: 1500,
                cols: 5
            }, {
                width: 1100,
                cols: 4
            }, {
                width: 800,
                cols: 3
            }, {
                width: 480,
                cols: 2
            }, {
                width: 320,
                cols: 1
            }],
            caption: 'overlayBottomReveal',
            displayType: 'sequentially',
            displayTypeSpeed: 80,

            // lightbox
            lightboxDelegate: '.cbp-lightbox',
            lightboxGallery: true,
            lightboxTitleSrc: 'data-title',
            lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',

            // singlePage popup
            singlePageDelegate: '.cbp-singlePage',
            singlePageDeeplinking: true,
            singlePageStickyNavigation: true,
            singlePageCounter: '<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',
            /*singlePageCallback: function(url, element) {
             // to update singlePage content use the following method: this.updateSinglePage(yourContent)
             var t = this;

             $.ajax({
             url: url,
             type: 'GET',
             dataType: 'html',
             timeout: 10000
             })
             .done(function(result) {
             t.updateSinglePage(result);
             })
             .fail(function() {
             t.updateSinglePage('AJAX Error! Please refresh the page!');
             });
             },*/
       });
        $('#js-grid-juicy-projects3').cubeportfolio({
            filters: '#js-filters-juicy-projects3',
            loadMore: '#js-loadMore-juicy-projects3',
            loadMoreAction: 'click',
            layoutMode: 'grid',
            defaultFilter: '*',
            animationType: 'quicksand',
            gapHorizontal: 35,
            gapVertical: 30,
            gridAdjustment: 'responsive',
            mediaQueries: [{
                width: 1500,
                cols: 5
            }, {
                width: 1100,
                cols: 4
            }, {
                width: 800,
                cols: 3
            }, {
                width: 480,
                cols: 2
            }, {
                width: 320,
                cols: 1
            }],
            caption: 'overlayBottomReveal',
            displayType: 'sequentially',
            displayTypeSpeed: 80,

            // lightbox
            lightboxDelegate: '.cbp-lightbox',
            lightboxGallery: true,
            lightboxTitleSrc: 'data-title',
            lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',

            // singlePage popup
            singlePageDelegate: '.cbp-singlePage',
            singlePageDeeplinking: true,
            singlePageStickyNavigation: true,
            singlePageCounter: '<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',
            /*singlePageCallback: function(url, element) {
             // to update singlePage content use the following method: this.updateSinglePage(yourContent)
             var t = this;

             $.ajax({
             url: url,
             type: 'GET',
             dataType: 'html',
             timeout: 10000
             })
             .done(function(result) {
             t.updateSinglePage(result);
             })
             .fail(function() {
             t.updateSinglePage('AJAX Error! Please refresh the page!');
             });
             },*/
     /*   });*/

});
   // })(jQuery, window, document);
});