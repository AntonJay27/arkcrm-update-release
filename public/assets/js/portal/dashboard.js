let baseUrl = $('#txt_baseUrl').val();

const DASHBOARD = (function(){

	let thisDashboard = {};

	var Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });

  thisDashboard.loadAllCampaigns = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DashboardController->loadAllCampaigns() */
      url : `${baseUrl}/dashboard/load-all-campaigns`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        $('#lbl_campaignsCount').text(data);
      }
    });
  }

  thisDashboard.loadAllContacts = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DashboardController->loadAllContacts() */
      url : `${baseUrl}/dashboard/load-all-contacts`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        $('#lbl_contactsCount').text(data);
      }
    });
  }

  thisDashboard.loadContactChart = function(monthYearDate)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $('#modal_contactChart').modal('show');
    $.ajax({
      /* DashboardController->loadContactReports() */
      url : `${baseUrl}/dashboard/load-contact-reports`,
      method : 'get',
      dataType: 'json',
      data: {monthYearDate:monthYearDate},
      success : function(data)
      {
        $('body').waitMe('hide');
        const ctx = document.getElementById('canvas_contactChart');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: data['arrLabels'],
            datasets: [{
              label: 'Contacts',
              data: data['arrData'],
              borderWidth: 1,
              backgroundColor: '#28A745'
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                    min: 0,
                    stepSize: 1
                },
                scaleLabel: {
                  display : true,
                  labelString: 'Number of Contacts'
                }
              }],
              xAxes: [{
                scaleLabel: {
                  display : true,
                  labelString: 'Days of the Month'
                }
              }]
            }
          }
        });
      }
    });
  }

  thisDashboard.loadAllOrganizations = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DashboardController->loadAllOrganizations() */
      url : `${baseUrl}/dashboard/load-all-organizations`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        $('#lbl_organizationsCount').text(data);
      }
    });
  }

  thisDashboard.loadOrganizationChart = function(monthYearDate)
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $('#modal_organizationChart').modal('show');
    $.ajax({
      /* DashboardController->loadOrganizationReports() */
      url : `${baseUrl}/dashboard/load-organization-reports`,
      method : 'get',
      dataType: 'json',
      data: {monthYearDate:monthYearDate},
      success : function(data)
      {
        $('body').waitMe('hide');
        const ctx = document.getElementById('canvas_organizationChart');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: data['arrLabels'],
            datasets: [{
              label: 'Organizations',
              data: data['arrData'],
              borderWidth: 1,
              backgroundColor: '#FFC107'
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                    min: 0,
                    stepSize: 1
                },
                scaleLabel: {
                  display : true,
                  labelString: 'Number of Organizations'
                }
              }],
              xAxes: [{
                scaleLabel: {
                  display : true,
                  labelString: 'Days of the Month'
                }
              }]
            }
          }
        });
      }
    });
  }

  thisDashboard.loadAllUsers = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DashboardController->loadAllUsers() */
      url : `${baseUrl}/dashboard/load-all-users`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        $('#lbl_usersCount').text(data);
      }
    });
  }

  thisDashboard.loadSummaryReports = function()
  {
    $('body').waitMe(_waitMeLoaderConfig);
    $.ajax({
      /* DashboardController->loadSummaryReports() */
      url : `${baseUrl}/dashboard/load-summary-reports`,
      method : 'get',
      dataType: 'json',
      success : function(data)
      {
        $('body').waitMe('hide');
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
          type: 'pie',
          data: {
            labels: ['Campaigns', 'Contacts', 'Organizations','Users'],
            datasets: [{
              label: '# of Votes',
              data: data,
              backgroundColor: [
                '#17A2B8',
                '#28A745',
                '#FFC107',
                '#DC3545'
              ],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        }); 
      }
    });
  }

  return thisDashboard;

})();