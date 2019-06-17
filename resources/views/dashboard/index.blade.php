@extends('layouts.horizontal.main')

@section('content.main')
    <div class="row d-flex align-items-center">
        <div class="col-md-4 col-xl-4">
            <div id="redirect_stocks"
                 class="card-box tilebox-one bg-{{ $color_stock['bg'] }} text-{{ $color_stock['text'] }} mini-card pointer">
                <i class="icon-layers float-right"></i>
                <h6 class="m-b-20 text-uppercase">Stocks</h6>
                <h3 class="m-b-20 text-center text-uppercase">statut</h3>
                <div class="text-center">
                    @if (!empty($infos_buffers))
                        <?php $count_stock = 0; ?>
                        @foreach($infos_buffers as $infos_buffer)
                            <?php $count_stock++; ?>
                            <div class="badge bg-light text-{{ $color_stock['bg'] }} display_stock"
                                 style="">
                                <span> {{ $infos_buffer['product_name'] }} | {{ $infos_buffer['stock'] }}</span></div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="card-box tilebox-one mb-0 mini-card">
                <i class="icon-social-dropbox float-right text-muted"></i>
                <h6 class="text-muted text-uppercase">ventes</h6>
                <div class="text-center">
                    @if (!empty($infos_sales['today_sale']))
                        <?php $count_sale = 0; ?>
                        @foreach($infos_sales['today_sale'] as $key => $product_sold)
                            <?php $count_sale++; ?>
                            <div class="badge badge-dark display_sale" style="">
                                <span> {{ $key }} | {{ $product_sold }}</span></div>
                        @endforeach
                    @endif
                </div>
                <span class="badge badge-danger" style="padding-top : 7px;">{{ (!empty($infos_sales['percentage_sale'])) ? $infos_sales['percentage_sale'] : 0 }} %</span>
                <span class="text-muted">comparé à hier</span>
            </div>
        </div>

        <div class="col-lg-8 col-xl-8">
            <div class="card-box m-auto">
                <h4 class="header-title m-t-0 m-b-20 text-muted">Statistiques de vente</h4>
                <div class="text-center">
                    <ul class="list-inline chart-detail-list m-b-0">
                        <li class="list-inline-item">
                            <h6 style="color: #3db9dc;"><i class="zmdi zmdi-circle-o m-r-5"></i>Liquides</h6>
                        </li>
                        <li class="list-inline-item">
                            <h6 style="color: #1bb99a;"><i class="zmdi zmdi-triangle-up m-r-5"></i>Appareils</h6>
                        </li>
                        <li class="list-inline-item">
                            <h6 style="color: #818a91;"><i class="zmdi zmdi-square-o m-r-5"></i>Autres</h6>
                        </li>
                    </ul>
                </div>

                <div id="morris-bar-stacked" class="text-center" style="height: 320px;">
                    <svg height="320" version="1.1" width="816.65625" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         style="overflow: hidden; position: relative; top: -0.15625px;">
                        <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2</desc>
                        <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                        <text x="34.84375" y="281" text-anchor="end" font-family="sans-serif" font-size="12px"
                              stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
                        </text>
                        <path fill="none" stroke="#eeeeee" d="M47.34375,281H791.65625" stroke-width="0.5"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                        <text x="34.84375" y="217" text-anchor="end" font-family="sans-serif" font-size="12px"
                              stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan>
                        </text>
                        <path fill="none" stroke="#eeeeee" d="M47.34375,217H791.65625" stroke-width="0.5"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                        <text x="34.84375" y="153" text-anchor="end" font-family="sans-serif" font-size="12px"
                              stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">200</tspan>
                        </text>
                        <path fill="none" stroke="#eeeeee" d="M47.34375,153H791.65625" stroke-width="0.5"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                        <text x="34.84375" y="89" text-anchor="end" font-family="sans-serif" font-size="12px"
                              stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">300</tspan>
                        </text>
                        <path fill="none" stroke="#eeeeee" d="M47.34375,89H791.65625" stroke-width="0.5"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                        <text x="34.84375" y="25" text-anchor="end" font-family="sans-serif" font-size="12px"
                              stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">400</tspan>
                        </text>
                        <path fill="none" stroke="#eeeeee" d="M47.34375,25H791.65625" stroke-width="0.5"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                        <text x="757.8238636363636" y="293.5" text-anchor="middle" font-family="sans-serif"
                              font-size="12px" stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2015</tspan>
                        </text>
                        <text x="622.4943181818181" y="293.5" text-anchor="middle" font-family="sans-serif"
                              font-size="12px" stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2013</tspan>
                        </text>
                        <text x="487.16477272727275" y="293.5" text-anchor="middle" font-family="sans-serif"
                              font-size="12px" stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2011</tspan>
                        </text>
                        <text x="351.83522727272725" y="293.5" text-anchor="middle" font-family="sans-serif"
                              font-size="12px" stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2009</tspan>
                        </text>
                        <text x="216.5056818181818" y="293.5" text-anchor="middle" font-family="sans-serif"
                              font-size="12px" stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2007</tspan>
                        </text>
                        <text x="81.17613636363637" y="293.5" text-anchor="middle" font-family="sans-serif"
                              font-size="12px" stroke="none" fill="#888888"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                              font-weight="normal" transform="matrix(1,0,0,1,0,7)">
                            <tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2005</tspan>
                        </text>
                        <rect x="67.64318181818182" y="252.2" width="27.065909090909095" height="28.80000000000001"
                              rx="0" ry="0" fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="67.64318181818182" y="137" width="27.065909090909095" height="115.19999999999999"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="67.64318181818182" y="73" width="27.065909090909095" height="64" rx="0" ry="0"
                              fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="135.30795454545455" y="233" width="27.065909090909095" height="48" rx="0" ry="0"
                              fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="135.30795454545455" y="191.4" width="27.065909090909095" height="41.599999999999994"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="135.30795454545455" y="140.20000000000002" width="27.065909090909095"
                              height="51.19999999999999" rx="0" ry="0" fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="202.9727272727273" y="217" width="27.065909090909095" height="64" rx="0" ry="0"
                              fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="202.9727272727273" y="159.4" width="27.065909090909095" height="57.599999999999994"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="202.9727272727273" y="123.56" width="27.065909090909095" height="35.84" rx="0" ry="0"
                              fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="270.6375" y="233" width="27.065909090909095" height="48" rx="0" ry="0" fill="#3db9dc"
                              stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="270.6375" y="191.4" width="27.065909090909095" height="41.599999999999994" rx="0"
                              ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="270.6375" y="134.44" width="27.065909090909095" height="56.96000000000001" rx="0"
                              ry="0" fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="338.30227272727274" y="217" width="27.065909090909095" height="64" rx="0" ry="0"
                              fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="338.30227272727274" y="159.4" width="27.065909090909095" height="57.599999999999994"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="338.30227272727274" y="82.6" width="27.065909090909095" height="76.80000000000001"
                              rx="0" ry="0" fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="405.9670454545455" y="233" width="27.065909090909095" height="48" rx="0" ry="0"
                              fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="405.9670454545455" y="191.4" width="27.065909090909095" height="41.599999999999994"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="405.9670454545455" y="121" width="27.065909090909095" height="70.4" rx="0" ry="0"
                              fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="473.6318181818182" y="249" width="27.065909090909095" height="32" rx="0" ry="0"
                              fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="473.6318181818182" y="223.4" width="27.065909090909095" height="25.599999999999994"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="473.6318181818182" y="169" width="27.065909090909095" height="54.400000000000006"
                              rx="0" ry="0" fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="541.2965909090909" y="233" width="27.065909090909095" height="48" rx="0" ry="0"
                              fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="541.2965909090909" y="191.4" width="27.065909090909095" height="41.599999999999994"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="541.2965909090909" y="158.12" width="27.065909090909095" height="33.28" rx="0" ry="0"
                              fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="608.9613636363637" y="249" width="27.065909090909095" height="32" rx="0" ry="0"
                              fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="608.9613636363637" y="223.4" width="27.065909090909095" height="25.599999999999994"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="608.9613636363637" y="174.12" width="27.065909090909095" height="49.28" rx="0" ry="0"
                              fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="676.6261363636364" y="233" width="27.065909090909095" height="48" rx="0" ry="0"
                              fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="676.6261363636364" y="191.4" width="27.065909090909095" height="41.599999999999994"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="676.6261363636364" y="133.8" width="27.065909090909095" height="57.599999999999994"
                              rx="0" ry="0" fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="744.2909090909092" y="217" width="27.065909090909095" height="64" rx="0" ry="0"
                              fill="#3db9dc" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="744.2909090909092" y="159.4" width="27.065909090909095" height="57.599999999999994"
                              rx="0" ry="0" fill="#1bb99a" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                        <rect x="744.2909090909092" y="76.20000000000002" width="27.065909090909095"
                              height="83.19999999999999" rx="0" ry="0" fill="#ebeff2" stroke="none" fill-opacity="1"
                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect>
                    </svg>
                    <div class="morris-hover morris-default-style" style="left: 166.49px; top: 107px; display: none;">
                        <div class="morris-hover-row-label">2007</div>
                        <div class="morris-hover-point" style="color: #3db9dc">
                            Series A:
                            100
                        </div>
                        <div class="morris-hover-point" style="color: #1bb99a">
                            Series B:
                            90
                        </div>
                        <div class="morris-hover-point" style="color: #ebeff2">
                            Series C:
                            56
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
        </div>
    </div>
@endsection

@section('css')
    @parent
    <link href="{{ url('plugins/switchery/switchery.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('plugins/morris/morris.css') }}" rel="stylesheet">
@endsection

@section('footer.js')
    @parent
    <script src="{{ url('plugins/js/detect.js') }}"></script>
    <script src="{{ url('plugins/js/fastclick.js') }}"></script>
    <script src="{{ url('plugins/js/jquery.blockUI.js') }}"></script>
    <script src="{{ url('plugins/js/waves.js') }}"></script>
    <script src="{{ url('plugins/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ url('plugins/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ url('plugins/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ url('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('plugins/morris/morris.min.js') }}'"></script>
    <script src="{{ url('plugins/raphael/raphael-min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#redirect_stocks').click(function () {
                        {{-- document.location.href = "{!! route('stock.index'); !!}"; --}}
                let form = document.createElement('form');
                form.setAttribute('method', 'get');
                form.setAttribute('action', "{!! route('derive.low-stock'); !!}");
                form.style.display = 'hidden';
                document.body.appendChild(form);
                form.submit();
            });
            @if (!empty($count_stock) && $count_stock >= 7)
            $('.display_stock').css({
                'display': 'none',
            });
            @endif
            @if(!empty($count_sale) && $count_sale >= 7)
            $('.display_sale').css({
                'display': 'none',
            });
            @endif
        });
    </script>
@endsection











