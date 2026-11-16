@extends('layouts.app')

@section('title', 'Dashboard Refer | ' . config('app.app_abbr', 'YSOPOD'))

@push('styles')
<style>
  /* === Table Styling === */
  .custom-table {
    border-collapse: separate !important;
    border-spacing: 0 !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
  }
  .custom-table thead th {
    font-weight: 700 !important;
    text-align: center !important;
    vertical-align: middle !important;
    padding: 10px 8px !important;
    font-size: 0.85rem !important;
  }
  .custom-table tbody td {
    padding: 8px !important;
    font-size: 0.85rem !important;
    color: #444 !important;
  }
  .custom-table tbody tr:hover {
    background-color: #f8fbff !important;
  }
  
  /* Header Color Groups */
  .th-blue { background: #e3f2fd !important; color: #0d47a1 !important; }
  .th-green { background: #e8f5e9 !important; color: #1b5e20 !important; }
  .th-orange { background: #fff3e0 !important; color: #e65100 !important; }
  .th-purple { background: #f3e5f5 !important; color: #4a148c !important; }
  .th-red { background: #ffebee !important; color: #b71c1c !important; }
  .th-grey { background: #f5f5f5 !important; color: #424242 !important; }
  
  .tr-total {
    background: #f1f8ff !important;
    font-weight: 800 !important;
    border-top: 2px solid #0d47a1 !important;
  }

  .card-hover {
    transition: all 0.3s ease-in-out;
  }
  .card-hover:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
  }

  /* Summary Cards (Crisp White + Accent Borders) */
  .card-theme-referout {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #d32f2f !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }
  .card-theme-referin {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #0d47a1 !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }
  .card-theme-referback {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #1b5e20 !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }

  /* Chart Cards Minimal */
  .card.card-chart-referout {
    border-top: 4px solid #d32f2f !important;
    background: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
  }
  .card.card-chart-referin {
    border-top: 4px solid #0d47a1 !important;
    background: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
  }
  .card.card-chart-referback {
    border-top: 4px solid #1b5e20 !important;
    background: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
  }
</style>
@endpush

@section('content')

  <!-- HERO -->
  <header class="py-4">
    <div class="container-fluid">      
        <div class="row g-4 align-items-center">
          <div class="col-lg-7">          
            <div class="d-flex align-items-center gap-3">
              <div class="bg-danger bg-opacity-10 rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border: 1px solid rgba(239, 68, 68, 0.2);">
                <i class="fa-solid fa-truck-medical fs-4 text-danger"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-1" style="color: #1e293b;">ข้อมูลส่งต่อผู้ป่วย (Refer)</h4>
                <p class="text-secondary small mb-0"><i class="fa-solid fa-square-poll-vertical text-green me-1"></i>{{ config('app.province_name_en', 'Yasothon') }} One Province One Data</p>
              </div>
            </div>          
          </div>
          {{-- ขวาสุด: วันที่ + ปุ่มโหลดใหม่ --}}
          <div class="col-lg-5 d-flex justify-content-lg-end align-items-center gap-3">
            <span class="text-secondary small fw-medium">
                วันที่ {{ \Carbon\Carbon::now()->locale('th')->isoFormat('D MMM YYYY เวลา H:mm') }} น.
            </span>
            <button type="button" class="btn btn-sm btn-glass-action" onclick="location.reload();">
              <i class="bi bi-arrow-clockwise"></i> โหลดใหม่
            </button>
          </div>
        </div>
    </div>
  </header>

  @php
    $fmtInt   = fn($n) => number_format((int)($n ?? 0));
    $fmtMoney = fn($n) => number_format((float)($n ?? 0), 2);
  @endphp

  <!-- แถว 3 Block สรุป (Refer Out, In, Back) -->
  <section id="summary-refer" class="pb-2">
    <div class="container-fluid">      
      <div class="row justify-content-center g-3">

        <!-- Refer Out -->
        <div class="col-12 col-sm-6 col-xl-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#ReferOutDetailModal" class="text-decoration-none text-dark d-block">
            <div class="card card-theme-referout card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0 fw-bold" style="color: #d32f2f;">Refer Out วันนี้</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(211, 47, 47, 0.1);">
                  <i class="fa-solid fa-truck-medical fs-4" style="color: #d32f2f;"></i>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-around text-center">
                <div>
                  <div class="small text-secondary">OPD</div>
                  <div class="fw-bold" style="font-size:1.6rem; color: #d32f2f;">
                    {{ $fmtInt(($visit_referout_inprov ?? 0) + ($visit_referout_outprov ?? 0)) }}
                  </div>
                </div>
                <div class="vr mx-2" style="opacity: 0.15;"></div>
                <div>
                  <div class="small text-secondary">IPD</div>
                  <div class="fw-bold" style="font-size:1.6rem; color: #d32f2f;">
                    {{ $fmtInt(($visit_referout_inprov_ipd ?? 0) + ($visit_referout_outprov_ipd ?? 0)) }}
                  </div>
                </div>
                <div class="vr mx-2" style="opacity: 0.15;"></div>
                <div>
                  <div class="small text-secondary">รวม</div>
                  <div class="fw-bold text-dark" style="font-size:1.6rem;">
                    {{ $fmtInt(($visit_referout_inprov ?? 0) + ($visit_referout_outprov ?? 0) + ($visit_referout_inprov_ipd ?? 0) + ($visit_referout_outprov_ipd ?? 0)) }}
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <!-- Refer In -->
        <div class="col-12 col-sm-6 col-xl-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#ReferInDetailModal" class="text-decoration-none text-dark d-block">
            <div class="card card-theme-referin card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0 fw-bold" style="color: #0d47a1;">Refer In วันนี้</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(13, 71, 161, 0.1);">
                  <i class="fa-solid fa-truck-medical fs-4" style="color: #0d47a1;"></i>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-around text-center">
                <div>
                  <div class="small text-secondary">OPD</div>
                  <div class="fw-bold" style="font-size:1.6rem; color: #0d47a1;">
                    {{ $fmtInt(($visit_referin_inprov ?? 0) + ($visit_referin_outprov ?? 0)) }}
                  </div>
                </div>
                <div class="vr mx-2" style="opacity: 0.15;"></div>
                <div>
                  <div class="small text-secondary">IPD</div>
                  <div class="fw-bold" style="font-size:1.6rem; color: #0d47a1;">
                    {{ $fmtInt(($visit_referin_inprov_ipd ?? 0) + ($visit_referin_outprov_ipd ?? 0)) }}
                  </div>
                </div>
                <div class="vr mx-2" style="opacity: 0.15;"></div>
                <div>
                  <div class="small text-secondary">รวม</div>
                  <div class="fw-bold text-dark" style="font-size:1.6rem;">
                    {{ $fmtInt(($visit_referin_inprov ?? 0) + ($visit_referin_outprov ?? 0) + ($visit_referin_inprov_ipd ?? 0) + ($visit_referin_outprov_ipd ?? 0)) }}
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <!-- Refer Back -->
        <div class="col-12 col-sm-6 col-xl-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#ReferBackDetailModal" class="text-decoration-none text-dark d-block">
            <div class="card card-theme-referback card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0 fw-bold" style="color: #1b5e20;">Refer Back วันนี้</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(27, 94, 32, 0.1);">
                  <i class="fa-solid fa-truck-medical fs-4" style="color: #1b5e20;"></i>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-around text-center">
                <div>
                  <div class="small text-secondary">ในจังหวัด</div>
                  <div class="fw-bold" style="font-size:1.6rem; color: #1b5e20;">
                    {{ $fmtInt($visit_referback_inprov ?? 0) }}
                  </div>
                </div>
                <div class="vr mx-2" style="opacity: 0.15;"></div>
                <div>
                  <div class="small text-secondary">ต่างจังหวัด</div>
                  <div class="fw-bold" style="font-size:1.6rem; color: #1b5e20;">
                    {{ $fmtInt($visit_referback_outprov ?? 0) }}
                  </div>
                </div>
                <div class="vr mx-2" style="opacity: 0.15;"></div>
                <div>
                  <div class="small text-secondary">รวม</div>
                  <div class="fw-bold text-dark" style="font-size:1.6rem;">
                    {{ $fmtInt(($visit_referback_inprov ?? 0) + ($visit_referback_outprov ?? 0)) }}
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

      </div>
    </div>
  </section>

  {{-- MODALS FOR REFER --}}
  @include('partials.dashboard_refer_modals')

  <hr class="my-4">
  
  {{-- เลือกปีงบประมาณ --}}
  <section id="budget-year-select" class="pb-2">
      <div class="container-fluid">
        <form method="POST" action="{{ url('web/refer') }}" enctype="multipart/form-data">
        @csrf
          <div class="row g-4 align-items-center">
            <div class="col-lg-8">          
              <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-hospital text-primary me-2"></i>ข้อมูลจำแนกรายโรงพยาบาล</h5>          
            </div>
            <div class="col-lg-4 d-flex justify-content-lg-end">
              <div class="d-flex align-items-center gap-2">
                <select class="form-select rounded-pill px-3 shadow-sm border-0" name="budget_year" style="min-width: 160px; background-color: #ffffff;">
                  @foreach ($budget_year_select as $row)
                    <option value="{{ $row->LEAVE_YEAR_ID }}"
                      {{ (int)$budget_year === (int)$row->LEAVE_YEAR_ID ? 'selected' : '' }}>
                      {{ $row->LEAVE_YEAR_NAME }}
                    </option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fa-solid fa-magnifying-glass me-1"></i> {{ __('ค้นหา') }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
  </section>

  <!-- ข้อมูลบริการรายโรงพยาบาล -->
  <section id="hospital" class="pb-4">
    <div class="container-fluid">
      
      <!-- NAV PILLS -->
      <ul class="nav nav-pills overflow-auto flex-nowrap pb-1" id="hospPills" role="tablist">
        @foreach($hospitalData as $hospcode => $data)
        @php
          $shortName = preg_replace('/^(โรงพยาบาลสมเด็จพระยุพราช|โรงพยาบาล)/u', 'รพ.', $data['hospname']);
        @endphp
        <li class="nav-item me-2" role="presentation">
          <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $hospcode }}" data-bs-toggle="pill" data-bs-target="#pane-{{ $hospcode }}" type="button" role="tab" aria-controls="pane-{{ $hospcode }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
            <i class="fa-solid fa-hospital me-1"></i> {{ $shortName }}
          </button>
        </li>
        @endforeach
      </ul>

      <!-- TAB PANES -->
      <div class="tab-content mt-3" id="hospPillsContent">

        @foreach($hospitalData as $hospcode => $data)
        @php
          $refer_records = $data['refer'];
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pane-{{ $hospcode }}" role="tabpanel" aria-labelledby="tab-{{ $hospcode }}" tabindex="0">          
          <div class="glass p-3" style="background: rgba(255,255,255,0.85) !important;">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-truck-arrow-right text-primary me-2"></i>[{{ $hospcode }}] ข้อมูลการส่งต่อ Refer {{ $data['hospname'] }} ปีงบประมาณ {{$budget_year}}</h6>
              <div class="d-flex align-items-center gap-2">
                <span class="text-secondary small">Update {{ $data['update_at'] ?? '-' }}</span>
                <button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" id="btn-{{ $hospcode }}-refer">
                  <i class="fa-solid fa-file-excel me-1"></i> ส่งออก Excel
                </button>
              </div>
            </div>

            <!-- 3 Charts Side-by-Side (Refer Out, Refer In, Refer Back) -->
            <div class="row g-3 mb-4">
              {{-- Chart 1: Refer Out (Red) --}}
              <div class="col-12 col-lg-4">
                <div class="card card-chart-referout h-100 rounded-4 border-0">
                  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0" style="color: #d32f2f;"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Refer Out</h6>
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">OPD vs IPD</span>
                  </div>
                  <div class="card-body p-2">
                    <div id="chart_{{ $hospcode }}_referout" style="min-height: 220px;"></div>
                  </div>
                </div>
              </div>

              {{-- Chart 2: Refer In (Blue) --}}
              <div class="col-12 col-lg-4">
                <div class="card card-chart-referin h-100 rounded-4 border-0">
                  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0" style="color: #0d47a1;"><i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Refer In</h6>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">OPD vs IPD</span>
                  </div>
                  <div class="card-body p-2">
                    <div id="chart_{{ $hospcode }}_referin" style="min-height: 220px;"></div>
                  </div>
                </div>
              </div>

              {{-- Chart 3: Refer Back (Green) --}}
              <div class="col-12 col-lg-4">
                <div class="card card-chart-referback h-100 rounded-4 border-0">
                  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0" style="color: #1b5e20;"><i class="fa-solid fa-arrow-rotate-left me-1"></i> Refer Back</h6>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill">ใน/ต่าง จว.</span>
                  </div>
                  <div class="card-body p-2">
                    <div id="chart_{{ $hospcode }}_referback" style="min-height: 220px;"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
              <table id="table{{ $hospcode }}_refer" class="table custom-table my-3" width="100%">
                <thead>
                  <tr>
                    <th class="th-grey" rowspan="2" width="8%">เดือน</th>
                    <th class="th-red" colspan="4">Refer Out</th>
                    <th class="th-blue" colspan="4">Refer In</th>
                    <th class="th-green" colspan="2">Refer Back</th>
                  </tr>
                  <tr>
                    <th class="th-red">OPD ในจังหวัด</th>
                    <th class="th-red">OPD ต่างจังหวัด</th>
                    <th class="th-red">IPD ในจังหวัด</th>
                    <th class="th-red">IPD ต่างจังหวัด</th>
                    <th class="th-blue">OPD ในจังหวัด</th>
                    <th class="th-blue">OPD ต่างจังหวัด</th>
                    <th class="th-blue">IPD ในจังหวัด</th>
                    <th class="th-blue">IPD ต่างจังหวัด</th>
                    <th class="th-green">ในจังหวัด</th>
                    <th class="th-green">ต่างจังหวัด</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $t_out_op_in = 0; $t_out_op_out = 0; $t_out_ip_in = 0; $t_out_ip_out = 0;
                    $t_in_op_in = 0; $t_in_op_out = 0; $t_in_ip_in = 0; $t_in_ip_out = 0;
                    $t_back_in = 0; $t_back_out = 0;
                  @endphp
                  @foreach($refer_records as $row)
                    @php
                      $t_out_op_in += $row->visit_referout_inprov ?? 0;
                      $t_out_op_out += $row->visit_referout_outprov ?? 0;
                      $t_out_ip_in += $row->visit_referout_inprov_ipd ?? 0;
                      $t_out_ip_out += $row->visit_referout_outprov_ipd ?? 0;
                      $t_in_op_in += $row->visit_referin_inprov ?? 0;
                      $t_in_op_out += $row->visit_referin_outprov ?? 0;
                      $t_in_ip_in += $row->visit_referin_inprov_ipd ?? 0;
                      $t_in_ip_out += $row->visit_referin_outprov_ipd ?? 0;
                      $t_back_in += $row->visit_referback_inprov ?? 0;
                      $t_back_out += $row->visit_referback_outprov ?? 0;
                    @endphp
                    <tr>
                      <td class="text-center fw-bold">{{ $row->month }}</td>
                      <td class="text-end">{{ number_format($row->visit_referout_inprov) }}</td>
                      <td class="text-end">{{ number_format($row->visit_referout_outprov) }}</td>
                      <td class="text-end text-danger fw-bold">{{ number_format($row->visit_referout_inprov_ipd) }}</td>
                      <td class="text-end text-danger fw-bold">{{ number_format($row->visit_referout_outprov_ipd) }}</td>
                      <td class="text-end">{{ number_format($row->visit_referin_inprov) }}</td>
                      <td class="text-end">{{ number_format($row->visit_referin_outprov) }}</td>
                      <td class="text-end text-primary fw-bold">{{ number_format($row->visit_referin_inprov_ipd) }}</td>
                      <td class="text-end text-primary fw-bold">{{ number_format($row->visit_referin_outprov_ipd) }}</td>
                      <td class="text-end text-success fw-bold">{{ number_format($row->visit_referback_inprov) }}</td>
                      <td class="text-end text-success fw-bold">{{ number_format($row->visit_referback_outprov) }}</td>
                    </tr>
                  @endforeach
                  {{-- Total Row --}}
                  <tr class="tr-total">
                    <td class="text-center text-primary">รวม</td>
                    <td class="text-end text-danger">{{ number_format($t_out_op_in) }}</td>
                    <td class="text-end text-danger">{{ number_format($t_out_op_out) }}</td>
                    <td class="text-end text-danger">{{ number_format($t_out_ip_in) }}</td>
                    <td class="text-end text-danger">{{ number_format($t_out_ip_out) }}</td>
                    <td class="text-end text-primary">{{ number_format($t_in_op_in) }}</td>
                    <td class="text-end text-primary">{{ number_format($t_in_op_out) }}</td>
                    <td class="text-end text-primary">{{ number_format($t_in_ip_in) }}</td>
                    <td class="text-end text-primary">{{ number_format($t_in_ip_out) }}</td>
                    <td class="text-end text-success">{{ number_format($t_back_in) }}</td>
                    <td class="text-end text-success">{{ number_format($t_back_out) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        @endforeach

      </div>
    </div>
  </section>

@endsection

@push('scripts')
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  
  {{-- DataTables + Buttons --}}
  <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-buttons/js/buttons.print.min.js') }}"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const referData = @json($hospitalData);

      // Common ApexChart Area Generator
      const createApexRefer = (elementId, seriesData, categories, colors) => {
        const el = document.querySelector(elementId);
        if (!el) return null;
        const options = {
          series: seriesData,
          chart: {
            type: 'area',
            height: 220,
            sparkline: { enabled: false },
            toolbar: { show: false },
            fontFamily: 'inherit',
            animations: { enabled: true, easing: 'easeinout', speed: 500 }
          },
          colors: colors,
          fill: {
            type: 'gradient',
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.45,
              opacityTo: 0.05,
              stops: [0, 95, 100]
            }
          },
          stroke: { curve: 'smooth', width: 2.5 },
          xaxis: {
            categories: categories,
            labels: { style: { fontSize: '11px', colors: '#64748b' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
          },
          yaxis: {
            labels: {
              formatter: val => Math.round(val),
              style: { fontSize: '11px', colors: '#64748b' }
            }
          },
          dataLabels: { enabled: false },
          legend: {
            position: 'top',
            horizontalAlign: 'right',
            fontSize: '11px',
            offsetY: -5
          },
          tooltip: {
            y: {
              formatter: val => (val || 0).toLocaleString('th-TH') + ' ราย'
            }
          },
          grid: {
            borderColor: 'rgba(0,0,0,0.05)',
            strokeDashArray: 4
          }
        };
        const chart = new ApexCharts(el, options);
        chart.render();
        return chart;
      };

      // Loop each hospital and render 3 ApexCharts
      Object.entries(referData).forEach(([code, h]) => {
        const rows = h.refer || [];
        const months = rows.map(r => r.month);

        // Chart 1: Refer Out (OPD vs IPD)
        const refOutOpd = rows.map(r => (parseInt(r.visit_referout_inprov) || 0) + (parseInt(r.visit_referout_outprov) || 0));
        const refOutIpd = rows.map(r => (parseInt(r.visit_referout_inprov_ipd) || 0) + (parseInt(r.visit_referout_outprov_ipd) || 0));
        createApexRefer(
          `#chart_${code}_referout`,
          [
            { name: 'OPD Refer Out', data: refOutOpd },
            { name: 'IPD Refer Out', data: refOutIpd }
          ],
          months,
          ['#ef4444', '#b91c1c']
        );

        // Chart 2: Refer In (OPD vs IPD)
        const refInOpd = rows.map(r => (parseInt(r.visit_referin_inprov) || 0) + (parseInt(r.visit_referin_outprov) || 0));
        const refInIpd = rows.map(r => (parseInt(r.visit_referin_inprov_ipd) || 0) + (parseInt(r.visit_referin_outprov_ipd) || 0));
        createApexRefer(
          `#chart_${code}_referin`,
          [
            { name: 'OPD Refer In', data: refInOpd },
            { name: 'IPD Refer In', data: refInIpd }
          ],
          months,
          ['#2563eb', '#1d4ed8']
        );

        // Chart 3: Refer Back (ในจังหวัด vs ต่างจังหวัด)
        const refBackIn = rows.map(r => parseInt(r.visit_referback_inprov) || 0);
        const refBackOut = rows.map(r => parseInt(r.visit_referback_outprov) || 0);
        createApexRefer(
          `#chart_${code}_referback`,
          [
            { name: 'ในจังหวัด', data: refBackIn },
            { name: 'ต่างจังหวัด', data: refBackOut }
          ],
          months,
          ['#10b981', '#059669']
        );

        // DataTables init for this hospital
        const tblId = `#table${code}_refer`;
        if ($.fn.DataTable && $(tblId).length) {
          const dt = $(tblId).DataTable({
            paging: false,
            searching: false,
            info: false,
            responsive: true,
            order: [],
            buttons: [
              {
                extend: 'excelHtml5',
                text: 'Excel',
                title: `ข้อมูลการส่งต่อ Refer [${code}] ${h.hospname} ปีงบประมาณ {{ $budget_year }}`,
                className: 'd-none'
              }
            ]
          });
          $(`#btn-${code}-refer`).on('click', () => {
            dt.button('.buttons-excel').trigger();
          });
        }
      });

      // Resize listener for hidden tabs
      $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function () {
        window.dispatchEvent(new Event('resize'));
      });
    });
  </script>
@endpush
