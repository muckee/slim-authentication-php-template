$(document).ready(function() {
    setInterval(function() {
      getTime(updateTime);
    }, 1000);
    setInterval(function() {
      getDate(updateDate);
    }, 60000);
});

function getTime(callback) {
  $.ajax({
    url: '/time',
    success: function(data) {
      var time = JSON.stringify(data.time).slice(1, -1);
      callback(time);
    },
  });
}

function getDate(callback) {
  $.ajax({
    url: '/date',
    success: function(data) {
      var date = JSON.stringify(data.date).slice(1, -1);
      callback(date);
    },
  });
}

function updateTime(time) {
  $('#currentTime').html(time);
}

function updateDate(date) {
  $('#currentDate').html(date);
}
