@extends('painel.layouts.app')
@section('content')
@if($idRole == 2)

    <div class="row">
    <div class="col-xxl-12 m-b-30">
        <div class="card card-statistics h-100 mb-0 o-hidden">

        <div class="card-body">
            <div class="col-12 mb-12">
            <div class="alert alert-danger" role="alert">
                Iremos entrar em contato o mais rápido possível
            </div>
            </div>
        </div>

        </div>
    </div>
    </div>
    @elseif($idRole == 6)
    <div class="row">
    <div class="col-xxl-12 m-b-30">
        <div class="card card-statistics h-100 mb-0 o-hidden">

        <div class="card-body">
            <div class="col-12 mb-12">
            <div class="alert alert-danger" role="alert">
                Conta Desativada
            </div>
            </div>
        </div>

        </div>
    </div>
    </div>

@else

    {{-- GRAFICO 01 --}}
    <div class="row">

        <div class="col-md-8 col-12 col-lg-8 m-b-30">
            <div class="card card-statistics h-100 mb-0 apexchart-tool-force-top">
                <div class="card-header d-flex justify-content-between">
                <div class="card-heading">
                    <h4 class="card-title"><i class="fas fa-hand-holding-usd"></i> Ganhos</h4>
                </div>
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-12 px-0">
                    <div class="apexchart-wrapper p-inherit">
                        <div id="earingsDays"></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12 col-lg-4 m-b-30">

            {{-- IMPRESSÕES --}}
            <div class="col-lg-12 col-md-12 col-12">
            <div class="card card-statistics">
                <div class="card-body pb-xs-0">
                <div class="row">
                    <div class="col">
                    <div class="media">
                        <a href="#" class="btn btn-icon btn-round info font-30 mr-4 text-center" title="Atualizar/Visualizar" style="width: 50px; height: 50px; vertical-align: middle; line-height: 50px; background: rgb(215,104,87);
                        background: radial-gradient(circle, #ff6d00 24%, #ff7900  26%, #ff9100 100%);">
                        <i class="fa fa-sort-numeric-asc" style="color: #fff;"></i>
                        </a>
                        <div class="media-body pb-0">
                        <h4 class="mb-1">Impressões</h4>
                        <p> @if(empty($today->impressions)) 0,00 @else {{number_format($today->impressions,0,'.','.')}} @endif Hoje</p>
                        </div>
                    </div>
                    </div>
                    <div class="col ml-auto text-right">
                    <span class="d-block">@if(empty($yesterday->impressions)) 0.00 @else {{number_format($yesterday->impressions,0,'.','.')}} @endif Ontem</span>
                    @if(empty($today->impressions) && empty($yesterday->impressions))
                        <?php $percentImpressions = number_format(0,2,'.','.'); ?>
                    @elseif(empty($today->impressions))
                        <?php $percentImpressions = number_format(-100,2,'.','.') ?>
                    @elseif(empty($yesterday->impressions))
                        <?php $percentImpressions = number_format(100,2,'.','.') ?>
                    @else
                        <?php $percentImpressions = number_format((($today->impressions/$yesterday->impressions)*100) - 100,2,'.','.');?>
                    @endif
                    <span class="@if($percentImpressions < 0) text-danger  @elseif($percentImpressions == 0) text-default @else  text-success  @endif">
                        @if($percentImpressions > 0) + @endif {{$percentImpressions}}%
                        <i class="fa @if($percentImpressions < 0) fa-level-down  @elseif($percentImpressions == 0) @else  fa-level-up  @endif"></i>
                    </span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col">
                    <div class="apexchart-wrapper">
                        <div id="impressions"></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>

            {{--  Viewability --}}

            <div class="col-lg-12 col-md-12 col-12 col-xxl-4">
            <div class="card card-statistics" style="margin-bottom: -10px;">
                <div class="card-body pb-xs-0">
                <div class="row">
                    <div class="col">
                    <div class="media">
                        <a href="#" class="btn btn-icon btn-round info font-30 mr-4 text-center" title="Atualizar/Visualizar" style="width: 50px; height: 50px; vertical-align: middle; line-height: 50px; background: rgb(215,104,87);
                        background: radial-gradient(circle, #7209b7 24%, #8338ec 26%, #7400b8 100%);">
                        <i class="fa fa-eye" style="color: #fff;"></i>
                        </a>
                        <div class="media-body">
                        <h4 class="mb-1">Viewability</h4>
                        <p>@if(empty($today->active_view_viewable)) 0.00 @else {{number_format($today->active_view_viewable,2,',','.')}} @endif % Hoje</p>
                        </div>
                    </div>
                    </div>
                    <div class="col ml-auto text-right">
                    <span class="d-block">@if(empty($yesterday->active_view_viewable)) 0,00% @else {{number_format($yesterday->active_view_viewable,2,',','.')}}% @endif Ontem</span>
                    @if(empty($today->active_view_viewable) && empty($yesterday->active_view_viewable))
                        <?php $percentActiveView = number_format(0,2,'.','.'); ?>
                    @elseif(empty($today->active_view_viewable))
                        <?php $percentActiveView = number_format(-100,2,'.','.'); ?>
                    @elseif(empty($yesterday->active_view_viewable))
                        <?php $percentActiveView = number_format(100,2,'.','.') ?>
                    @else
                        <?php $percentActiveView = number_format((($today->active_view_viewable/$yesterday->active_view_viewable)*100) - 100,2,'.','.');?>
                    @endif
                    <span class="@if($percentActiveView < 0) text-danger @elseif($percentActiveView == 0) text-default @else  text-success  @endif">
                        @if($percentActiveView > 0) + @endif {{$percentActiveView}}%
                        <i class="fa @if($percentActiveView < 0)  fa-level-down  @elseif($percentActiveView == 0) @else  fa-level-up  @endif"></i>
                    </span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col">
                    <div class="apexchart-wrapper">
                        <div id="activeView"></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>


        </div>

    </div>

<div class="row">

  <div class="col-lg-4 col-xxl-4">
    <div class="card card-statistics">
      <div class="card-body pb-xs-0">
        <div class="row">
          <div class="col">
            <div class="media">
              <a href="#" class="btn btn-icon btn-round info font-30 mr-4 text-center" title="Atualizar/Visualizar" style="width: 50px; height: 50px; vertical-align: middle; line-height: 50px; background: rgb(215,104,87);
              background: radial-gradient(circle, #ff206e 24%, #ff006e 26%, #f72585 100%);">
                <i class="fa fa-money" style="color: #fff;"></i>
              </a>
              <div class="media-body">
                <h4 class="mb-1">eCPM ($)</h4>
                <p>
                  @if(isset($today->impressions) && isset($today->earnings))
                    @if($today->impressions != 0 && $today->earnings != 0)
                    {{number_format((($today->earnings/$today->impressions)*1000),2,',','.')}}
                    @else
                    0,00
                    @endif
                  @else
                    0,00
                  @endif
                  Hoje
                </p>
              </div>
            </div>
          </div>
          <div class="col ml-auto text-right">
            <span class="d-block">
              @if(isset($yesterday->impressions) && isset($yesterday->earnings))
                @if($yesterday->impressions != 0 && $yesterday->earnings != 0)
                {{number_format((($yesterday->earnings/$yesterday->impressions)*1000),2,',','.')}}
                @else
                0,00
                @endif
              @else
                0,00
              @endif
              Ontem
            </span>
            @if(empty($today->ecpm) && empty($yesterday->ecpm))
              <?php $percentEcpm = number_format(0,2,'.','.'); ?>
            @elseif(empty($today->ecpm))
              <?php $percentEcpm = number_format(-100,2,'.','.'); ?>
            @elseif(empty($yesterday->ecpm))
              <?php $percentEcpm = number_format(100,2,'.','.') ?>
            @else
              <?php $percentEcpm = number_format((($today->ecpm/$yesterday->ecpm)*100) - 100,2,'.','.');?>
            @endif
            <span class="@if($percentEcpm < 0)  text-danger @elseif($percentEcpm == 0) text-default  @else  text-success  @endif">
              @if($percentEcpm > 0) + @endif {{$percentEcpm}}
              <i class="fa @if($percentEcpm < 0)  fa-level-down  @elseif($percentEcpm == 0) @else  fa-level-up  @endif"></i>
            </span>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col">
            <div class="apexchart-wrapper">
              <div id="ecpm"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-xxl-4">
    <div class="card card-statistics">
      <div class="card-body pb-xs-0">
        <div class="row">
          <div class="col">
            <div class="media">
              <a href="#" class="btn btn-icon btn-round info font-30 mr-4 text-center" title="Atualizar/Visualizar" style="width: 50px; height: 50px; vertical-align: middle; line-height: 50px; background: rgb(215,104,87);
              background: radial-gradient(circle, #00c5bf 24%, #3dccc7 26%, #07beb8 100%);">
                <i class="fa fa-usd" style="color: #fff;"></i>
              </a>
              <div class="media-body">
                <h4 class="mb-1">Receita ($)</h4>
                <p>@if(empty($today->earnings)) 0,00 @else {{number_format($today->earnings,2,',','.')}} @endif Hoje</p>
              </div>
            </div>
          </div>

          <div class="col ml-auto text-right">
            <span class="d-block">@if(empty($yesterday->earnings)) 0,00 @else {{number_format($yesterday->earnings,2,',','.')}} @endif Ontem</span>
            @if(empty($today->earnings) && empty($yesterday->earnings))
              <?php $percentEarnings = number_format(0,2,'.','.'); ?>
            @elseif(empty($today->earnings))
              <?php $percentEarnings = number_format(-100,2,'.','.'); ?>
            @elseif(empty($yesterday->earnings))
              <?php $percentEarnings = number_format(100,2,'.','.') ?>
            @else
              <?php $percentEarnings = number_format((($today->earnings/$yesterday->earnings)*100) - 100,2,'.','.');?>
            @endif

            <span class="@if($percentEarnings < 0)  text-danger @elseif($percentEarnings == 0) text-default @else  text-success  @endif">
              @if($percentEarnings > 0) + @endif {{$percentEarnings}}
              <i class="fa @if($percentEarnings < 0) fa-level-down @elseif($percentEarnings == 0) @else  fa-level-up  @endif"></i>
            </span>
          </div>

        </div>
        <div class="row align-items-center">
          <div class="col">
            <div class="apexchart-wrapper">
              <div id="recipe"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-xxl-4">
    <div class="card card-statistics">
      <div class="card-body pb-xs-0">
        <div class="row">
          <div class="col">
            <div class="media">
              <a href="#" class="btn btn-icon btn-round info font-30 mr-4 text-center" title="Atualizar/Visualizar" style="width: 50px; height: 50px; vertical-align: middle; line-height: 50px; background: rgb(215,104,87);
              background: radial-gradient(circle, #9ef01a 24%, #38b000 26%, #008000 100%);">
                <i class="fa fa-money" style="color: #fff;"></i>
              </a>
              <div class="media-body">
                <h4 class="mb-1">Ganhos do mês ($)</h4>
                <p>@if(empty($month)) 0,00 @else {{number_format($month,2,',','.')}} @endif Atual</p>
              </div>
            </div>
          </div>
          <div class="col ml-auto text-right">
            <span class="d-block">@if(empty($monthLast)) 0,00 @else {{number_format($monthLast,2,',','.')}} @endif Passado</span>
            @if(empty($month) && empty($monthLast))
              <?php $percentEarnings = number_format(0,2,'.','.'); ?>
            @elseif(empty($month))
              <?php $percentEarnings = number_format(-100,2,'.','.'); ?>
            @elseif(empty($monthLast))
              <?php $percentEarnings = number_format(100,2,'.','.') ?>
            @else
              <?php $percentEarnings = number_format((($month/$monthLast)*100) - 100,2,'.','.');?>
            @endif

            @if(!empty($earningsInvalid->value))
            <span class="d-block" style="color: red">{{number_format($earningsInvalid->value,2,',','.')}} Inválidos</span>
            <span class="d-block" style="color: green">{{number_format(($earningsInvalid->value - $monthLast),2,',','.')}} Ganhos</span>
            @endif
            <span class="@if($percentEarnings < 0)  text-danger @elseif($percentEarnings == 0) text-default @else  text-success  @endif">
              @if($percentEarnings > 0) + @endif {{$percentEarnings}}
              <i class="fa @if($percentEarnings < 0) fa-level-down @elseif($percentEarnings == 0) @else  fa-level-up  @endif"></i>
            </span>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col">
            <div class="apexchart-wrapper">
              <div id="earingsMonth"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="verticalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verticalCenterTitle">Mensagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(isset($modal->image))
        <img src="{{URL('assets/painel/uploads/modal')}}/{{$modal->image}}" class="img-fluid">
        @endif
      </div>
    </div>
  </div>
</div>

@endif
@endsection


@section('scripts')

@if(isset($modal->id_modal))
<script>
$('#modalInfo').modal('show');
function closeModal(){
  $.get("{{URL('/painel/modal/modal-close')}}/"+{{$modal->id_modal}}, function( data ) {
    console.log(data)
  });
}
</script>
@endif



<script>

    // ======================================================================
//earings
var earingsDays = jQuery('#earingsDays')
if (earingsDays.length > 0) {
  var options = {
    chart: {
      height: 300,
      type: 'area',
      toolbar: {
        show: true,
        tools: {
          download: true,
          selection: false,
          zoom: false,
          zoomin: false,
          zoomout: false,
          pan: false,
          customIcons: []
        },
        autoSelected: 'zoom'
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: 'smooth'
    },
    markers: {
    size: 4,

    hover: {
      sizeOffset: 6
    }
    },
    series: [{
      name: 'Receita',
      data: [@foreach($data as $dado) {{$dado->earnings}}, @endforeach]
    }],
    colors: ['#06d6a0'],
    xaxis: {
      type: 'datetime',
      categories: [ @foreach($data as $dado) '{{$dado->date}}', @endforeach ],
    },
    tooltip: {
      x: {
        format: 'dd/MM/yy'
      },
    },
    grid: {
        position: 'front',
        show: true,
        borderColor: '#4b4a57',
        strokeDashArray: 7,
    }
  }

  var chart = new ApexCharts(
    document.querySelector("#earingsDays"),
    options
  );

  chart.render();
}


// impressions
var impressions = jQuery('#impressions')
if (impressions.length > 0) {

  var options = {
    chart: {
      height: 110,
      type: 'area',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: [4],
      curve: 'smooth',
      dashArray: [0, 4]
    },
    colors: ['#ff8500'],
    series: [{
      name: "Impressões",
      data: [ @foreach($data as $dado) {{$dado->impressions}}, @endforeach ]
    },
  ],
  markers: {
    size: 4,

    hover: {
      sizeOffset: 6
    }
  },
  xaxis: {
    lines: {
      show: false
    },
    axisBorder: {
      show: false
    },
    crosshairs: {
      show: false
    },
    axisTicks: {
      show: false
    },
    labels: {
      show: false,
    },
    categories: [ @foreach($data as $dado) '{{date("d/m/Y", strtotime($dado->date))}}', @endforeach
  ],
},
tooltip: {
  y: [{
    title: {
      formatter: function (val) {
        return val
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val + " per session"
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val;
      }
    }
  }]
},
legend: {
  show: false,
},
grid: {
  show: false,
  borderColor: '#f1f1f1',
}
}

var chart = new ApexCharts(
  document.querySelector("#impressions"),
  options
);

chart.render();
}

// ecpm
var ecpm = jQuery('#ecpm')
if (ecpm.length > 0) {

  var options = {
    chart: {
      height: 160,
      type: 'area',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: [4],
      curve: 'smooth',
      dashArray: [0, 4]
    },
    colors: ['#ff006e'],
    series: [{
      name: "eCPM",
      data: [ @foreach($data as $dado) {{$dado->ecpm}}, @endforeach ]
    },
  ],
  markers: {
    size: 4,

    hover: {
      sizeOffset: 6
    }
  },
  xaxis: {
    lines: {
      show: false
    },
    axisBorder: {
      show: false
    },
    crosshairs: {
      show: false
    },
    axisTicks: {
      show: false
    },
    labels: {
      show: false,
    },
    categories: [ @foreach($data as $dado) '{{date("d/m/Y", strtotime($dado->date))}}', @endforeach
  ],
},
tooltip: {
  y: [{
    title: {
      formatter: function (val) {
        return val
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val + " per session"
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val;
      }
    }
  }]
},
legend: {
  show: false,
},
grid: {
  show: false,
  borderColor: '#f1f1f1',
}
}

var chart = new ApexCharts(
  document.querySelector("#ecpm"),
  options
);

chart.render();
}

// activeView
var activeView = jQuery('#activeView')
if (activeView.length > 0) {

  var options = {
    chart: {
      height: 110,
      type: 'area',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: [4],
      curve: 'smooth',
      dashArray: [0, 4]
    },
    colors: ['#9d4edd'],
    series: [{
      name: "Viewability",
      data: [ @foreach($data as $dado) {{$dado->active_view_viewable}}, @endforeach ]
    },
  ],
  markers: {
    size: 4,

    hover: {
      sizeOffset: 5
    }
  },
  xaxis: {
    lines: {
      show: true
    },
    axisBorder: {
      show: false
    },
    crosshairs: {
      show: true
    },
    axisTicks: {
      show: false
    },
    labels: {
      show: false,
    },
    categories: [ @foreach($data as $dado) '{{date("d/m/Y", strtotime($dado->date))}}', @endforeach
  ],
},
tooltip: {
  y: [{
    title: {
      formatter: function (val) {
        return val
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val + " per session"
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val;
      }
    }
  }]
},
legend: {
  show: false,
},
grid: {
  show: false,
  borderColor: '#f1f1f1',
}
}

var chart = new ApexCharts(
  document.querySelector("#activeView"),
  options
);

chart.render();
}

// recipe
var recipe = jQuery('#recipe')
if (recipe.length > 0) {

  var options = {
    chart: {
      height: 160,
      type: 'area',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: [4],
      curve: 'smooth',
      dashArray: [0, 4]
    },
    colors: ['#68d8d6'],
    series: [{
      name: "Receita",
      data: [ @foreach($data as $dado) {{$dado->earnings}}, @endforeach ]
    },
  ],
  markers: {
    size: 4,

    hover: {
      sizeOffset: 6
    }
  },
  xaxis: {
    lines: {
      show: true
    },
    axisBorder: {
      show: false
    },
    crosshairs: {
      show: false
    },
    axisTicks: {
      show: false
    },
    labels: {
      show: false,
    },
    categories: [ @foreach($data as $dado) '{{date("d/m/Y", strtotime($dado->date))}}', @endforeach
  ],
},
tooltip: {
  y: [{
    title: {
      formatter: function (val) {
        return val
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val + " per session"
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val;
      }
    }
  }]
},
legend: {
  show: false,
},
grid: {
  show: false,
  borderColor: '#f1f1f1',
}
}

var chart = new ApexCharts(
  document.querySelector("#recipe"),
  options
);

chart.render();
}

// earingsMonth
var recipe = jQuery('#earingsMonth')
if (recipe.length > 0) {

  var options = {
    chart: {
      height: 140,
      type: 'area',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: [4],
      curve: 'smooth',
      dashArray: [0, 4]
    },
    colors: ['#9ef01a'],
    series: [{
      name: "Receita",
      data: [ @foreach($data as $dado) {{$dado->earnings}}, @endforeach ]
    },
  ],
  markers: {
    size: 4,

    hover: {
      sizeOffset: 6
    }
  },
  xaxis: {
    lines: {
      show: false
    },
    axisBorder: {
      show: false
    },
    crosshairs: {
      show: false
    },
    axisTicks: {
      show: false
    },
    labels: {
      show: false,
    },
    categories: [ @foreach($data as $dado) '{{date("d/m/Y", strtotime($dado->date))}}', @endforeach
  ],
},
tooltip: {
  y: [{
    title: {
      formatter: function (val) {
        return val
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val + " per session"
      }
    }
  }, {
    title: {
      formatter: function (val) {
        return val;
      }
    }
  }]
},
legend: {
  show: false,
},
grid: {
  show: false,
  borderColor: '#f1f1f1',
}
}

var chart = new ApexCharts(
  document.querySelector("#earingsMonth"),
  options
);

chart.render();
}
</script>
@endsection
