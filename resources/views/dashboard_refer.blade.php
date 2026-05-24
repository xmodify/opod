@extends('layouts.app')

@section('title', 'Dashboard | YSOPOD')

<style>
  /* === BASE GLASS CARD === */
  .glass-card {
    backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 8px 20px rgba(0,0,0,0.18);
    color: #fff;
    min-height: 110px;
    padding: 12px 14px !important;
    border-radius: 16px;
    position: relative;
  }
  .glass-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.20);
    border: 1px solid rgba(255,255,255,0.26);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 10px;
    right: 10px;
  }
  .glass-icon i {
    color: #ffffff;
    font-size: 1.05rem;
  }
  .glass-title {
    font-weight: bold;
    font-size: .9rem;
    margin-bottom: 2px;
  }
  .glass-number {
    font-size: 1.75rem;
    font-weight: bold;
    margin-top: 6px;
    text-align: center;
  }

  /* Refer Out – Magenta Glass */
  .glass-referout {
    background: linear-gradient(135deg,
                rgba(180,40,160,0.55),
                rgba(255,115,195,0.25));
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    color: #fff0ff;
  }
  .glass-referout .glass-title,
  .glass-referout .glass-number {
    color: #fff0ff !important;
  }

  /* Refer In – Pink Red Glass */
  .glass-referin {
    background: linear-gradient(135deg,
                rgba(220,40,90,0.55),
                rgba(255,130,160,0.28));
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    color: #ffe6ea;
  }
  .glass-referin .glass-title,
  .glass-referin .glass-number {
    color: #ffffff !important;
  }

  /* Refer Back – Warm Yellow Glass */
  .glass-referback {
    background: linear-gradient(135deg,
                rgba(255,180,60,0.55),
                rgba(255,225,120,0.28));
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    color: #5e4800;
  }
  .glass-referback .glass-title,
  .glass-referback .glass-number {
    color: #5e4800 !important;
  }

  tr.table-refer td,
  tr.table-refer th {
    background: linear-gradient(135deg, #ceebfa, #e8f6fc) !important;   
  }
</style>

@section('content')

  <!-- HERO -->
  <header class="py-4">
    <div class="container-fluid">      
        <div class="row g-4 align-items-center">
          <div class="col-lg-9">          
            <h4 class="text-success mb-2"><strong>Yasothon One Province One Data : YSOPOD</strong></h4>          
          </div>
          <div class="col-lg-3 d-flex justify-content-lg-end">
            <span class="text-secondary my-1">
                วันที่ {{ \Carbon\Carbon::now()->locale('th')->isoFormat('D MMM YYYY เวลา H:mm') }} น.&nbsp;&nbsp;
            </span>
            <button type="button" class="btn btn-sm btn-outline-success" onclick="location.reload();">
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

  <!-- แถว 2 จำนวน 3 Block สำหรับ Refer -->
  <section id="summary" class="pb-2">
    <div class="container-fluid">      
      <div class="row g-3">
        
        <!-- Refer Out ------------------------------------------------------------------------------------------>
        <div class="col-12 col-sm-6 col-xl-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#ReferOutDetailModal" class="text-decoration-none text-dark">
            <div class="glass-card glass-referout">
              <div class="glass-icon"><i class="fa-solid fa-truck-medical"></i></div>
              <div class="glass-title"><h6>Refer Out วันนี้</h6></div>
              <div class="d-flex justify-content-between text-center mt-1">
                <div class="flex-fill">
                  <div class="small">OPD</div>
                  <div class="glass-number fs-4">
                    {{ $fmtInt($visit_referout_inprov + $visit_referout_outprov) }}
                  </div>
                </div>
                <div class="vr mx-2 d-none d-sm-block" style="opacity:0.4;"></div>
                <div class="flex-fill">
                  <div class="small">IPD</div>
                  <div class="glass-number fs-4">
                    {{ $fmtInt($visit_referout_inprov_ipd + $visit_referout_outprov_ipd) }}
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        
        <!-- Refer In  ----------------------------------------------------------------------------------------->
        <div class="col-12 col-sm-6 col-xl-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#ReferInDetailModal" class="text-decoration-none text-dark">
            <div class="glass-card glass-referin">
              <div class="glass-icon"><i class="fa-solid fa-truck-medical"></i></div>
              <div class="glass-title"><h6>Refer In วันนี้</h6></div>
              <div class="d-flex justify-content-between text-center mt-1">
                <div class="flex-fill">
                  <div class="small">OPD</div>
                  <div class="glass-number fs-4">
                    {{ $fmtInt($visit_referin_inprov + $visit_referin_outprov) }}
                  </div>
                </div>
                <div class="vr mx-2 d-none d-sm-block" style="opacity:0.4;"></div>
                <div class="flex-fill">
                  <div class="small">IPD</div>
                  <div class="glass-number fs-4">
                    {{ $fmtInt($visit_referin_inprov_ipd + $visit_referin_outprov_ipd) }}
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        
        <!-- Refer Back  --------------------------------------------------------------------------------------------->
        <div class="col-12 col-sm-6 col-xl-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#ReferBackDetailModal" class="text-decoration-none text-dark">
            <div class="glass-card glass-referback">
              <div class="glass-icon"><i class="fa-solid fa-truck-medical"></i></div>
              <div class="glass-title"><h6>Refer Back วันนี้</h6></div>
              <div class="d-flex justify-content-between text-center mt-1">
                <div class="flex-fill">
                  <div class="small">ในจังหวัด</div>
                  <div class="glass-number fs-4">
                    {{ $fmtInt($visit_referback_inprov) }}
                  </div>
                </div>
                <div class="vr mx-2 d-none d-sm-block" style="opacity:0.4;"></div>
                <div class="flex-fill">
                  <div class="small">ต่างจังหวัด</div>
                  <div class="glass-number fs-4">
                    {{ $fmtInt($visit_referback_outprov) }}
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

      </div>
    </div>
  </section>

  {{-- Modals --}}
  {{-- 1. Refer Out Modal --}}
  <div class="modal fade" id="ReferOutDetailModal" tabindex="-1" aria-labelledby="hospitalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
        <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #2f6fb6, #4b8edc);">
          <h5 class="modal-title fw-bold" id="hospitalDetailLabel">
            <i class="bi bi-arrow-left-right me-2"></i> Refer Out วันนี้
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-3">
          <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
            <thead style="background-color:#d9e8fb;">
              <tr class="text-center text-primary fw-semibold">
                <th rowspan="2" class="text-center align-middle">รหัส</th>
                <th rowspan="2" class="text-center align-middle">ชื่อโรงพยาบาล</th>
                <th colspan="2" style="border-right:1px solid #aac6ec;">OPD</th>
                <th colspan="2">IPD</th>
              </tr>
              <tr class="text-center text-primary fw-semibold">
                <th>ในจังหวัด</th>
                <th style="border-right:1px solid #aac6ec;">ต่างจังหวัด</th>
                <th>ในจังหวัด</th>
                <th>ต่างจังหวัด</th>
              </tr>
            </thead>
            <tbody>
              @foreach($hospitalSummary as $h)
                <tr>
                  <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                  <td>
                    <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                    <small class="text-muted">
                      {{ \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') }} น.
                    </small>
                  </td>
                  <td align="right" class="text-primary">{{ number_format($h->visit_referout_inprov) }}</td>
                  <td align="right" class="text-success">{{ number_format($h->visit_referout_outprov) }}</td>
                  <td align="right" class="text-primary">{{ number_format($h->visit_referout_inprov_ipd) }}</td>
                  <td align="right" class="fw-bold text-success">{{ number_format($h->visit_referout_outprov_ipd) }}</td>
                </tr>
              @endforeach
              <tr style="background-color:#eef4fb;" class="fw-bold text-end">
                <td colspan="2" class="text-center text-dark">รวมทั้งหมด</td>
                <td class="text-primary">{{ number_format($hospitalSummary->sum('visit_referout_inprov')) }}</td>
                <td class="text-success">{{ number_format($hospitalSummary->sum('visit_referout_outprov')) }}</td>
                <td class="text-primary">{{ number_format($hospitalSummary->sum('visit_referout_inprov_ipd')) }}</td>
                <td class="text-success">{{ number_format($hospitalSummary->sum('visit_referout_outprov_ipd')) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer" style="background-color:#eef4fb;">
          <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color:#3e7cc1; border-color:#3e7cc1;" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

  {{-- 2. Refer In Modal --}}
  <div class="modal fade" id="ReferInDetailModal" tabindex="-1" aria-labelledby="hospitalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
        <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #2f6fb6, #4b8edc);">
          <h5 class="modal-title fw-bold" id="hospitalDetailLabel">
            <i class="bi bi-arrow-left-right me-2"></i>Refer IN วันนี้
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-3">
          <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
            <thead style="background-color:#d9e8fb;">
              <tr class="text-center text-primary fw-semibold">
                <th rowspan="2" class="align-middle">รหัส</th>
                <th rowspan="2" class="align-middle">ชื่อโรงพยาบาล</th>
                <th colspan="2" style="border-right:1px solid #aac6ec;">OPD</th>
                <th colspan="2">IPD</th>
              </tr>
              <tr class="text-center text-primary fw-semibold">
                <th>ในจังหวัด</th>
                <th style="border-right:1px solid #aac6ec;">ต่างจังหวัด</th>
                <th>ในจังหวัด</th>
                <th>ต่างจังหวัด</th>
              </tr>
            </thead>
            <tbody>
              @foreach($hospitalSummary as $h)
                <tr>
                  <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                  <td>
                    <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                    <small class="text-muted">
                      {{ \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') }} น.
                    </small>
                  </td>
                  <td align="right" class="text-primary">{{ number_format($h->visit_referin_inprov) }}</td>
                  <td align="right" class="text-success">{{ number_format($h->visit_referin_outprov) }}</td>
                  <td align="right" class="text-primary">{{ number_format($h->visit_referin_inprov_ipd) }}</td>
                  <td align="right" class="fw-bold text-success">{{ number_format($h->visit_referin_outprov_ipd) }}</td>
                </tr>
              @endforeach
              <tr style="background-color:#eef4fb;" class="fw-bold text-end">
                <td colspan="2" class="text-center text-dark">รวมทั้งหมด</td>
                <td class="text-primary">{{ number_format($hospitalSummary->sum('visit_referin_inprov')) }}</td>
                <td class="text-success">{{ number_format($hospitalSummary->sum('visit_referin_outprov')) }}</td>
                <td class="text-primary">{{ number_format($hospitalSummary->sum('visit_referin_inprov_ipd')) }}</td>
                <td class="text-success">{{ number_format($hospitalSummary->sum('visit_referin_outprov_ipd')) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer" style="background-color:#eef4fb;">
          <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color:#3e7cc1; border-color:#3e7cc1;" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

  {{-- 3. Refer Back Modal --}}
  <div class="modal fade" id="ReferBackDetailModal" tabindex="-1" aria-labelledby="hospitalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
        <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #2f6fb6, #4b8edc);">
          <h5 class="modal-title fw-bold" id="hospitalDetailLabel">
            <i class="bi bi-arrow-left-right me-2"></i>Refer Back วันนี้
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-3">
          <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
            <thead style="background-color:#d9e8fb;">
              <tr class="text-center text-primary fw-semibold">
                <th class="text-center">รหัส</th>
                <th class="text-center">ชื่อโรงพยาบาล</th>
                <th>ในจังหวัด</th>
                <th>ต่างจังหวัด</th>
              </tr>
            </thead>
            <tbody>
              @foreach($hospitalSummary as $h)
                <tr>
                  <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                  <td>
                    <span class="fw-semibold text-dark">{{ $h->hospname }}</span><br>
                    <small class="text-muted">
                      {{ \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') }} น.
                    </small>
                  </td>
                  <td align="right" class="text-primary">{{ number_format($h->visit_referback_inprov) }}</td>
                  <td align="right" class="fw-bold text-success">{{ number_format($h->visit_referback_outprov) }}</td>
                </tr>
              @endforeach
              <tr style="background-color:#eef4fb;" class="fw-bold text-end">
                <td colspan="2" class="text-center text-dark">รวมทั้งหมด</td>
                <td class="text-primary">{{ number_format($hospitalSummary->sum('visit_referback_inprov')) }}</td>
                <td class="text-success">{{ number_format($hospitalSummary->sum('visit_referback_outprov')) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer" style="background-color:#eef4fb;">
          <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background-color:#3e7cc1; border-color:#3e7cc1;" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

  <br>
  <hr>

  {{-- เลือกปีงบประมาณ ----------------------------------------------------------------------------------------------------------}}
  <section id="summary" class="pb-2">
      <div class="container-fluid">
        <form method="POST" action="{{ url('web/refer') }}" enctype="multipart/form-data">
        @csrf
          <div class="row g-4 align-items-center">
            <div class="col-lg-9">          
              <h6 class="text-success mb-2"><strong></strong></h6>          
            </div>
            <div class="col-lg-3 d-flex justify-content-lg-end">
              <div class="d-flex align-items-center gap-2">
                <select class="form-select" name="budget_year">
                  @foreach ($budget_year_select as $row)
                    <option value="{{ $row->LEAVE_YEAR_ID }}"
                      {{ (int)$budget_year === (int)$row->LEAVE_YEAR_ID ? 'selected' : '' }}>
                      {{ $row->LEAVE_YEAR_NAME }}
                    </option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-primary">{{ __('ค้นหา') }}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
  </section>

  {{-- ข้อมูลบริการ Refer แยกตามโรงพยาบาล ----------------------------------------------------------------------------------------------------------}}
  <section id="hospital" class="pb-2">
    <div class="container-fluid">
    
      <!-- NAV PILLS -->
      <ul class="nav nav-pills overflow-auto flex-nowrap" id="hospPills" role="tablist">
        @foreach($hospitalData as $hospcode => $data)
        <li class="nav-item me-2" role="presentation">
          <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $hospcode }}" data-bs-toggle="pill" data-bs-target="#pane-{{ $hospcode }}" type="button" role="tab" aria-controls="pane-{{ $hospcode }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
            {{ $data['hospname'] }}
          </button>
        </li>
        @endforeach
      </ul>

      <!-- TAB PANES -->
      <div class="tab-content mt-3" id="hospPillsContent">
        @foreach($hospitalData as $hospcode => $data)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pane-{{ $hospcode }}" role="tabpanel" aria-labelledby="tab-{{ $hospcode }}" tabindex="0">          
          <!-- Refer -->
          <div class="glass p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6>[{{ $hospcode }}] ข้อมูลการส่งต่อ Refer {{ $data['hospname'] }} ปีงบประมาณ {{$budget_year}}</h6>
              <span class="text-secondary small">Update {{ $data['update_at'] }}</span>
            </div>
            <div class="table-responsive">
              <table id="table{{ $hospcode }}_refer" class="table table-bordered table-striped my-3" width="100%">
                <thead class="table-light">
                  <tr class="table-refer">
                      <th class="text-center" rowspan="2" width="8%">เดือน</th>
                      <th class="text-center" colspan="4">Refer Out</th>
                      <th class="text-center" colspan="4">Refer In</th>
                      <th class="text-center" colspan="2">Refer Back</th>
                  </tr>
                  <tr class="table-refer">
                      <th class="text-center">OPD ในจังหวัด</th>
                      <th class="text-center">OPD ต่างจังหวัด</th>
                      <th class="text-center">IPD ในจังหวัด</th>
                      <th class="text-center">IPD ต่างจังหวัด</th>
                      <th class="text-center">OPD ในจังหวัด</th>
                      <th class="text-center">OPD ต่างจังหวัด</th>
                      <th class="text-center">IPD ในจังหวัด</th>
                      <th class="text-center">IPD ต่างจังหวัด</th>
                      <th class="text-center">ในจังหวัด</th>
                      <th class="text-center">ต่างจังหวัด</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($data['refer'] as $row)
                  <tr>
                    <td class="text-center">{{ $row->month }}</td>
                    <td class="text-end">{{ number_format($row->visit_referout_inprov) }}</td>
                    <td class="text-end">{{ number_format($row->visit_referout_outprov) }}</td>
                    <td class="text-end">{{ number_format($row->visit_referout_inprov_ipd) }}</td>
                    <td class="text-end">{{ number_format($row->visit_referout_outprov_ipd) }}</td>
                    <td class="text-end">{{ number_format($row->visit_referin_inprov) }}</td>
                    <td class="text-end">{{ number_format($row->visit_referin_outprov) }}</td>
                    <td class="text-end">{{ number_format($row->visit_referin_inprov_ipd) }}</td>
                    <td class="text-end">{{ number_format($row->visit_referin_outprov_ipd) }}</td>
                    <td class="text-end">{{ number_format($row->visit_referback_inprov) }}</td>
                    <td class="text-end">{{ number_format($row->visit_referback_outprov) }}</td>
                  </tr>
                @endforeach
                  <tr class="table-secondary fw-bold">
                    <td class="text-end">รวม</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referout_inprov')) }}</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referout_outprov')) }}</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referout_inprov_ipd')) }}</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referout_outprov_ipd')) }}</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referin_inprov')) }}</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referin_outprov')) }}</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referin_inprov_ipd')) }}</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referin_outprov_ipd')) }}</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referback_inprov')) }}</td>
                    <td class="text-end">{{ number_format($data['refer']->sum('visit_referback_outprov')) }}</td>
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
  <script>
    $(function () {
      @foreach($hospitalData as $hospcode => $data)
        $('#table{{ $hospcode }}_refer').DataTable({
          dom: '<"d-flex justify-content-end mb-2"B>rt',
          buttons: [
            {
              extend: 'excelHtml5',
              text: '<i class="bi bi-file-earmark-excel"></i> ส่งออก Excel',
              className: 'btn btn-success btn-sm',
              title: 'ข้อมูลการส่งต่อ Refer {{ $data['hospname'] }} {{ $budget_year ?? "" }}'
            }
          ],
          ordering: false,
          paging: false,
          info: false,
          lengthChange: false,
          language: { search: "ค้นหา:" }
        });
      @endforeach
    });
  </script>
@endpush
