$(document).ready(function() {

  let clickedLikeHandler = function(e) {
    e.preventDefault();

    var $link = $(e.currentTarget);

    $link.toggleClass('fa-heart-o').toggleClass('fa-heart');

    $.ajax({
      method: 'POST',
      url: $link.attr('href')
    }).done(function(data) {
      $('.js-like-article-count').html(data.hearts);
    });

  };

  $('.js-like-article').on('click', clickedLikeHandler.bind(this));
});
