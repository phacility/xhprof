<script type="text/javascript">
        var chart;
        $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    margin: [80, 200, 60, 100],
                    zoomType: 'xy',
                    events:
                     {
                        click: function(e)
                        {
                            // find the clicked values and the series
                            var x = e.xAxis[0].value,
                                y = e.yAxis[0].value,
                                series = this.series[0];        
                        }
                    }                    
                },
                credits: {
                	enabled:false
                },
                title: {
                    text: 'Data for XH Gui',
                    style: {
                        margin: '10px 0 0 0' // center it
                    }
                },
                subtitle: {
                    text: 'Source: XH Gui',
                    style: {
                        margin: '0 0 0 0' // center it
                    }
                },
                xAxis: [{
                    categories: [<?php echo $dateidsJS;?>],
                    labels: { 
                        formatter: function() {
                            var date = (this.value).split(" ");                            
                            return date[0];
                        },
                        rotation: -45,
                        align: 'right',
                    }
                    
                }],
                
                yAxis: [
                { // Primary yAxis
                    labels:
                    {   
                        formatter: function() {
                            return this.value;
                        },
                        style: {
                            color: '#89A54E'
                        }
                    },
                    title: {
                        text: 'Peak Memory Usage',
                        style: {
                            color: '#89A54E'
                        },
                        margin: 80
                    },
                    opposite: true
                    
                }, { // Secondary yAxis
                    title: {
                        text: 'CPU',
                        margin: 50,
                        style: {
                            color: '#4572A7'
                        }
                    },
                    labels: {
                        formatter: function() {
                            return this.value;
                        },
                        style: {
                            color: '#4572A7'
                        }
                    }
                    
                }, { // Tertiary yAxis
                    title: {
                        text: 'Wall Time (ms)',
                        margin: 80,
                        style: {
                            color: '#AA4643'
                        }
                    },
                    labels: {
                        formatter: function() {
                            return this.value;
                        },
                        style: {
                            color: '#AA4643'
                        }
                    },
                    opposite: true,
                    offset: 100
                }],
                tooltip: {
                    formatter: function() {
                        var unit = {
                            '': '',
                            '': '',
                            '': ''
                        }[this.series.name];
                          
                        return '<b>'+ this.series.name +'</b><br/><br/>' + this.y +'';
                    }
                },
                legend: {
                    layout: 'vertical',
                    style: {
                        left: '120px',
                        bottom: 'auto',
                        right: 'auto',
                        top: '90px'
                    },
                    backgroundColor: '#FFFFFF'
                },
                plotOptions: {
                      series: {
                        lineWidth: 1,
                          point: {
                            events: {
                                'click': function() {
                                      
                                      if (this.series.data.length > 1)  
                                      {
                                        var runid = (this.category).split(" ");
                                        document.location = '?run=' + runid[2];               
                                      }                                   
                                }
                            }
                        }
                    }
                },                     
                series: [{
                    name: 'CPU',
                    color: '#4572A7',
                    type: 'line',
                    yAxis: 1,
                    data: [<?php echo $cpuJS;?>],
                                 
                },{
                    name: 'Wall Time',
                    type: 'line',
                    color: '#AA4643',
                    yAxis: 2,
                    data: [<?php echo $wtJS;?>]        
                
                },{
                    name: 'Peak Memory Usage',
                    color: '#89A54E',
                    type: 'line',
                    data: [<?php echo $pmuJS;?>,]        
                }]
              });            
            
        });
</script>
