window.onload = function() {
    $.ajax({
      url: "getdata.php",
      method: "GET",
      success: function(data) {
        console.log(data);
        var ctx2 = document.getElementById('doughnut').getContext('2d');
        var myChart2 = new Chart(ctx2, {
          type: 'doughnut',
          data: {
            labels: ['Student', 'Lecturer'],
            datasets: [{
              label: 'User Register',
              data: data,
              backgroundColor: [
                'rgba(41, 155, 99, 1)',
                'rgba(54, 162, 235, 1)'
              ]
           
            }]
          },
          options: {
            responsive: true
          }
        });
      },
      error: function(data) {
        console.log(data);
      }
    });
  }