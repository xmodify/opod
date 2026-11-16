@extends('layouts.app')

@section('title', 'Dashboard Operation | ' . config('app.app_abbr', 'YSOPOD'))

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
  .th-purple { background: #f3e5f5 !important; color: #4a148c !important; }
  .th-grey { background: #f5f5f5 !important; color: #424242 !important; }
  
  .tr-total {
    background: #f1f8ff !important;
    font-weight: 800 !important;
    border-top: 2px solid #8b5cf6 !important;
  }

  .card-hover {
    transition: all 0.3s ease-in-out;
  }
  .card-hover:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
  }

  /* Summary Card (Crisp White + Purple Border) */
  .card-theme-op {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #8b5cf6 !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
  }

  /* Minimal Style Chart Card */
  .card.card-chart-purple {
    border-top: 4px solid #8b5cf6 !important;
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
              <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: rgba(139, 92, 246, 0.1); border: 1px solid rgba(139, 92, 246, 0.2);">
                <i class="fa-solid fa-heart-pulse fs-4" style="color: #8b5cf6;"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-1" style="color: #1e293b;">ข้อมูลการผ่าตัด (Operation)</h4>
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
  @endphp

  <!-- สรุปการผ่าตัดวันนี้ -->
  <section id="summary-operation" class="pb-2">
    <div class="container-fluid">
      <div class="row g-3">
        <div class="col-12 col-sm-6 col-xl-3">
          <a href="#" data-bs-toggle="modal" data-bs-target="#OperationDetailModal" class="text-decoration-none text-dark d-block">
            <div class="card card-theme-op card-hover p-3 h-100">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0 fw-bold" style="color: #7c3aed;">การผ่าตัด วันนี้</h6>
                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(139, 92, 246, 0.1);">
                  <i class="fa-solid fa-scissors fs-4" style="color: #8b5cf6;"></i>
                </div>
              </div>
              <div class="text-center my-2">
                <div class="fw-bold" style="font-size:2.2rem; color: #7c3aed;">
                  {{ $fmtInt($visit_operation ?? 0) }}
                </div>
                <div class="small text-secondary">เคสผ่าตัดทั้งหมด</div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- Modal รายละเอียดผ่าตัดแต่ละ รพ. --}}
  <div class="modal fade" id="OperationDetailModal" tabindex="-1" aria-labelledby="opDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
        <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #7c3aed, #8b5cf6);">
          <h5 class="modal-title fw-bold" id="opDetailLabel">
            <i class="fa-solid fa-scissors me-2"></i> ข้อมูลการผ่าตัด วันนี้
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-3">
          <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
            <thead style="background-color:#f3e5f5;">
              <tr class="text-center fw-semibold" style="color: #5b21b6;">
                <th>รหัส</th>
                <th>ชื่อโรงพยาบาล</th>
                <th>เคสผ่าตัด</th>
              </tr>
            </thead>
            <tbody>
              @foreach($hospitalSummary as $h)
                <tr>
                  <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                  <td>
                    <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                    <small class="text-muted">
                      {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
                    </small>
                  </td>
                  <td align="right" class="fw-bold" style="color: #7c3aed;">{{ number_format($h->visit_operation) }}</td>
                </tr>
              @endforeach
              <tr style="background-color:#eef4fb;" class="fw-bold text-end">
                <td colspan="2" class="text-center text-dark">รวมทั้งหมด</td>
                <td class="text-primary">{{ number_format($hospitalSummary->sum('visit_operation')) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer" style="background-color:#eef4fb;">
          <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

  <hr class="my-4">

  {{-- เลือกปีงบประมาณ --}}
  <section id="budget-year-select" class="pb-2">
      <div class="container-fluid">
        <form method="POST" action="{{ url('web/operation') }}" enctype="multipart/form-data">
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
          $op_records = $data['operation'];
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pane-{{ $hospcode }}" role="tabpanel" aria-labelledby="tab-{{ $hospcode }}" tabindex="0">          
          <div class="glass p-3" style="background: rgba(255,255,255,0.85) !important;">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-heart-pulse text-purple me-2"></i>[{{ $hospcode }}] ข้อมูลการผ่าตัด Operation {{ $data['hospname'] }} ปีงบประมาณ {{$budget_year}}</h6>
              <div class="d-flex align-items-center gap-2">
                <span class="text-secondary small">Update {{ $data['update_at'] ?? '-' }}</span>
                <button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" id="btn-{{ $hospcode }}-op">
                  <i class="fa-solid fa-file-excel me-1"></i> ส่งออก Excel
                </button>
              </div>
            </div>

            <!-- 1 ApexChart: Monthly Operation (Purple) -->
            <div class="row g-3 mb-4">
              <div class="col-12">
                <div class="card card-chart-purple h-100 rounded-4 border-0">
                  <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0" style="color: #7c3aed;"><i class="fa-solid fa-chart-line me-1"></i> ปริมาณเคสผ่าตัด รายเดือน</h6>
                    <span class="badge rounded-pill" style="background-color: rgba(139, 92, 246, 0.1); color: #8b5cf6;">เคส</span>
                  </div>
                  <div class="card-body p-2">
                    <div id="chart_{{ $hospcode }}_operation" style="min-height: 240px;"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
              <table id="table{{ $hospcode }}_op" class="table custom-table my-3" width="100%">
                <thead>
                  <tr>
                    <th class="th-grey" width="15%">เดือน</th>
                    <th class="th-purple">จำนวนเคสผ่าตัด (ครั้ง)</th>
                  </tr>
                </thead>
                <tbody>
                  @php $t_op = 0; @endphp
                  @foreach($op_records as $row)
                    @php $t_op += $row->visit_operation ?? 0; @endphp
                    <tr>
                      <td class="text-center fw-bold">{{ $row->month }}</td>
                      <td class="text-end fw-bold" style="color: #7c3aed;">{{ number_format($row->visit_operation) }}</td>
                    </tr>
                  @endforeach
                  {{-- Total Row --}}
                  <tr class="tr-total">
                    <td class="text-center" style="color: #7c3aed;">รวม</td>
                    <td class="text-end fw-bold" style="color: #7c3aed;">{{ number_format($t_op) }}</td>
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
      const opData = @json($hospitalData);

      // Loop each hospital and render ApexChart
      Object.entries(opData).forEach(([code, h]) => {
        const rows = h.operation || [];
        const months = rows.map(r => r.month);
        const dataVals = rows.map(r => parseInt(r.visit_operation || 0));

        const el = document.querySelector(`#chart_${code}_operation`);
        if (el) {
          const options = {
            series: [{ name: 'เคสผ่าตัด', data: dataVals }],
            chart: {
              type: 'area',
              height: 240,
              sparkline: { enabled: false },
              toolbar: { show: false },
              fontFamily: 'inherit',
              animations: { enabled: true, easing: 'easeinout', speed: 500 }
            },
            colors: ['#8b5cf6'],
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
              categories: months,
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
                formatter: val => (val || 0).toLocaleString('th-TH') + ' ครั้ง'
              }
            },
            grid: {
              borderColor: 'rgba(0,0,0,0.05)',
              strokeDashArray: 4
            }
          };
          const chart = new ApexCharts(el, options);
          chart.render();
        }

        // DataTables init for this hospital
        const tblId = `#table${code}_op`;
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
                title: `ข้อมูลการผ่าตัด Operation [${code}] ${h.hospname} ปีงบประมาณ {{ $budget_year }}`,
                className: 'd-none'
              }
            ]
          });
          $(`#btn-${code}-op`).on('click', () => {
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
