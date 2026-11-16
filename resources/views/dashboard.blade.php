@extends('layouts.app')

@section('title', 'Dashboard | ' . config('app.app_abbr', 'YSOPOD'))

@push('styles')
<style>
  .card-hospital {
    border: none;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease-in-out;
  }
  .text-purple {
    color: #8b5cf6 !important;
  }
  
  /* === Table Styling สวยๆ === */
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
  .text-orange { color: #e65100 !important; }
  
  /* === Premium Chart Cards (Minimal style) === */
  .card.card-chart-blue {
    border-top: 4px solid #2563eb !important;
  }
  .card.card-chart-blue .card-header {
    background: transparent !important;
    border-bottom: none !important;
    color: #2563eb !important;
    padding-top: 15px !important;
    padding-bottom: 2px !important;
  }
  .card.card-chart-orange {
    border-top: 4px solid #d97706 !important;
  }
  .card.card-chart-orange .card-header {
    background: transparent !important;
    border-bottom: none !important;
    color: #d97706 !important;
    padding-top: 15px !important;
    padding-bottom: 2px !important;
  }
  .card.card-chart-green {
    border-top: 4px solid #10b981 !important;
  }
  .card.card-chart-green .card-header {
    background: transparent !important;
    border-bottom: none !important;
    color: #10b981 !important;
    padding-top: 15px !important;
    padding-bottom: 2px !important;
  }
  .card.card-chart-red {
    border-top: 4px solid #ef4444 !important;
  }
  .card.card-chart-red .card-header {
    background: transparent !important;
    border-bottom: none !important;
    color: #ef4444 !important;
    padding-top: 15px !important;
    padding-bottom: 2px !important;
  }

  /* Base Glass Card */
  .card-hover {
    transition: all 0.3s ease-in-out;
  }
  .card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
  }

  .card-theme-admit {
    background: #ffffff !important;
    border: 1px solid var(--glass-bd) !important;
    border-left: 6px solid #475569 !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
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
              <div class="bg-danger bg-opacity-10 rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border: 1px solid rgba(244, 63, 94, 0.2);">
                <i class="fa-solid fa-bed-pulse fs-4 text-danger"></i>
              </div>
              <div>
                <h4 class="fw-bold mb-1" style="color: #1e293b;">ข้อมูลบริการผู้ป่วยใน (IPD)</h4>
                <p class="text-secondary small mb-0"><i class="fa-solid fa-square-poll-vertical text-green me-1"></i>{{ config('app.system_title', 'Yasothon One Province One Data') }}</p>
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

    $hospColors = [
      '10701' => ['border' => '#8b5cf6', 'bg_light' => '#f5f3ff', 'text' => '#7c3aed', 'icon_bg' => 'rgba(139, 92, 246, 0.12)'],
      '10963' => ['border' => '#06b6d4', 'bg_light' => '#ecfeff', 'text' => '#0891b2', 'icon_bg' => 'rgba(6, 182, 212, 0.12)'],
      '10964' => ['border' => '#ec4899', 'bg_light' => '#fdf2f8', 'text' => '#db2777', 'icon_bg' => 'rgba(236, 72, 153, 0.12)'],
      '10965' => ['border' => '#f59e0b', 'bg_light' => '#fef3c7', 'text' => '#d97706', 'icon_bg' => 'rgba(245, 158, 11, 0.12)'],
      '10966' => ['border' => '#3b82f6', 'bg_light' => '#eff6ff', 'text' => '#2563eb', 'icon_bg' => 'rgba(59, 130, 246, 0.12)'],
      '10967' => ['border' => '#10b981', 'bg_light' => '#ecfdf5', 'text' => '#059669', 'icon_bg' => 'rgba(16, 185, 129, 0.12)'],
      '10968' => ['border' => '#6366f1', 'bg_light' => '#eef2ff', 'text' => '#4f46e5', 'icon_bg' => 'rgba(99, 102, 241, 0.12)'],
      '10969' => ['border' => '#14b8a6', 'bg_light' => '#f0fdfa', 'text' => '#0d9488', 'icon_bg' => 'rgba(20, 184, 166, 0.12)'],
      '11444' => ['border' => '#f43f5e', 'bg_light' => '#fff1f2', 'text' => '#e11d48', 'icon_bg' => 'rgba(244, 63, 94, 0.12)'],
      // Fallback for Amnat Charoen codes if used
      '10985' => ['border' => '#8b5cf6', 'bg_light' => '#f5f3ff', 'text' => '#7c3aed', 'icon_bg' => 'rgba(139, 92, 246, 0.12)'],
      '10986' => ['border' => '#06b6d4', 'bg_light' => '#ecfeff', 'text' => '#0891b2', 'icon_bg' => 'rgba(6, 182, 212, 0.12)'],
      '10987' => ['border' => '#ec4899', 'bg_light' => '#fdf2f8', 'text' => '#db2777', 'icon_bg' => 'rgba(236, 72, 153, 0.12)'],
      '10988' => ['border' => '#f59e0b', 'bg_light' => '#fef3c7', 'text' => '#d97706', 'icon_bg' => 'rgba(245, 158, 11, 0.12)'],
      '10989' => ['border' => '#3b82f6', 'bg_light' => '#eff6ff', 'text' => '#2563eb', 'icon_bg' => 'rgba(59, 130, 246, 0.12)'],
      '10990' => ['border' => '#10b981', 'bg_light' => '#ecfdf5', 'text' => '#059669', 'icon_bg' => 'rgba(16, 185, 129, 0.12)'],
      '10703' => ['border' => '#f43f5e', 'bg_light' => '#fff1f2', 'text' => '#e11d48', 'icon_bg' => 'rgba(244, 63, 94, 0.12)'],
    ];
    $paletteList = array_values($hospColors);
  @endphp

  <!-- ข้อมูลเตียง ---------------------------------------------------------------------------------------- -->
  <section id="bed" class="pb-2">
    <div class="container-fluid">
      <div class="row g-3">

        <!-- กำลังรักษาอยู่ (แดงพาสเทล) --------------------------------------------------------------------------------------------->
        <div class="col-12 col-sm-6 col-xl-3">
          <a href="#" data-bs-toggle="modal" data-bs-target="#AdmiitDetailModal"
            class="text-decoration-none text-dark">

            <div class="card card-theme-admit card-hover glass p-3 h-100">

              <!-- ส่วนหัว -->
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="mb-0 fw-bold" style="color: #475569;">กำลังรักษาอยู่</h6>

                <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(71, 85, 105, 0.1);">
                  <i class="fa-solid fa-hospital-user fs-4" style="color: #475569;"></i>
                </div>
              </div>

              <!-- ตัวเลข -->
              <div class="d-flex justify-content-between text-center">

                <div class="flex-fill px-1">
                  <div class="small text-secondary">จำนวนเตียง</div>
                  <div class="fw-bold text-primary" style="font-size:1.9rem;">
                    {{ $fmtInt($total_bed_qty ?? 0) }}
                  </div>
                  <i class="fa-solid fa-bed text-primary"></i>
                </div>

                <div class="vr mx-2 d-none d-sm-block"></div>

                <div class="flex-fill px-1">
                  <div class="small text-secondary">Admit</div>
                  <div class="fw-bold text-danger" style="font-size:1.9rem;">
                    {{ $fmtInt($total_bed_use ?? 0) }}
                  </div>
                  <i class="fa-solid fa-bed-pulse text-danger"></i>
                </div>

                <div class="vr mx-2 d-none d-sm-block"></div>

                <div class="flex-fill px-1">
                  <div class="small text-secondary">เตียงว่าง</div>
                  <div class="fw-bold text-success" style="font-size:1.9rem;">
                    {{ $fmtInt($total_bed_empty ?? 0) }}
                  </div>
                  <i class="fa-solid fa-bed text-success"></i>
                </div>

              </div>
            </div>
          </a>
        </div>

        {{-- Modal แสดงรายละเอียด รพ. (โทนน้ำเงินพาสเทลเข้ม / กรอบเล็ก) --}}
        <div class="modal fade" id="AdmiitDetailModal" tabindex="-1" aria-labelledby="hospitalDetailLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
              
              <!-- Header -->
              <div class="modal-header text-white rounded-top-3" 
                  style="background: linear-gradient(135deg, #2f6fb6, #4b8edc);">
                <h5 class="modal-title fw-bold" id="hospitalDetailLabel">
                  <i class="fa-solid fa-bed-pulse fs-5"></i> ข้อมูลเตียง
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <!-- Body -->
              <div class="modal-body py-3">

                {{-- หน้ารวมโรงพยาบาล --}}
                <div id="hospital-list">
                  <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" 
                        style="background-color: #ffffff; border-radius: 0.75rem;">
                    <thead style="background-color:#d9e8fb;">
                      <tr class="text-center text-primary fw-semibold">
                        <th>รหัส</th>
                        <th>ชื่อโรงพยาบาล</th>
                        <th>จำนวนเตียง</th>
                        <th>Admit</th>
                        <th>เตียงว่าง</th>
                        <th>อัตราใช้เตียง (%)</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($ipd_bed_dep as $h)
                        @php
                          $bed_occupancy = $h->bed_qty > 0 ? ($h->bed_use / $h->bed_qty) * 100 : 0;
                          if ($bed_occupancy < 60) {
                            $rate_class = 'text-primary fw-semibold';
                          } elseif ($bed_occupancy < 80) {
                            $rate_class = 'text-warning fw-semibold';
                          } else {
                            $rate_class = 'text-danger fw-semibold';
                          }
                        @endphp

                        <tr>
                          <td align="right" class="text-secondary">{{ $h->hospcode }}</td>
                          <td>
                           <a href="#" 
                              class="fw-semibold text-dark text-decoration-none hosp-detail-link" 
                              data-hospcode="{{ $h->hospcode }}"
                              data-hospname="{{ $h->hospname }}">
                              {{ $h->hospname }}
                            </a><br>
                            <small class="text-muted">
                              {{ \Carbon\Carbon::parse($h->updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') }} น.
                            </small>
                          </td>
                          <td align="right" class="text-primary">{{ number_format($h->bed_qty) }}</td>
                          <td align="right" class="text-danger">{{ number_format($h->bed_use) }}</td>
                          <td align="right" class="fw-bold text-success">
                            {{ number_format($h->bed_qty - $h->bed_use) }}
                          </td>
                          <td align="right" class="{{ $rate_class }}">
                            {{ number_format($bed_occupancy, 2) }}%
                          </td>
                        </tr>
                      @endforeach

                      {{-- รวม --}}
                      @php
                        $sum_bed_qty = $ipd_bed_dep->sum('bed_qty');
                        $sum_bed_use = $ipd_bed_dep->sum('bed_use');
                        $total_occupancy = $sum_bed_qty > 0 ? ($sum_bed_use / $sum_bed_qty) * 100 : 0;
                      @endphp
                      <tr style="background-color:#eef4fb;" class="fw-bold text-end">
                        <td colspan="2" class="text-center text-dark">รวมทั้งหมด</td>
                        <td class="text-primary">{{ number_format($sum_bed_qty) }}</td>
                        <td class="text-danger">{{ number_format($sum_bed_use) }}</td>
                        <td class="text-success">{{ number_format($sum_bed_qty - $sum_bed_use) }}</td>
                        <td class="text-dark">{{ number_format($total_occupancy, 2) }}%</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                {{-- หน้ารายละเอียดเตียง (ซ่อนเริ่มต้น) --}}
                <div id="bed-detail" style="display: none;">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 id="modal-hospname" class="fw-bold text-success mb-0"></h6>
                    <button id="btn-back" class="btn btn-outline-primary btn-sm rounded-pill">
                      <i class="bi bi-arrow-left"></i> กลับ
                    </button>
                  </div>
                  <table class="table table-sm table-bordered align-middle" id="bedDetailTable">
                    <thead class="table-primary text-center">
                      <tr>
                        <th>รหัสเตียง</th>
                        <th>ชื่อแผนก</th>
                        <th>จำนวนเตียง</th>
                        <th>Admit</th>
                        <th>เตียงว่าง</th>
                        <th>อัตราใช้เตียง (%)</th>
                      </tr>
                    </thead>

                    <tbody class="text-center">
                      <tr><td colspan="6" class="text-muted">เลือกโรงพยาบาลเพื่อดูรายละเอียด...</td></tr>
                    </tbody>

                    <tfoot class="table-light text-end fw-bold">
                      <tr>
                        <td colspan="2" class="text-center">รวม</td>
                        <td id="sum-bed"></td>
                        <td id="sum-use"></td>
                        <td id="sum-empty"></td>
                        <td id="sum-rate" class="text-primary"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>

              </div>
              <!-- Footer -->
              <div class="modal-footer" style="background-color:#eef4fb;">
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" 
                        style="background-color:#3e7cc1; border-color:#3e7cc1;" 
                        data-bs-dismiss="modal">
                  ปิด
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Block แยกแต่ละ รพ (การ์ดขาวขอบสี ดูสะอาดเหมือน AOPOD) ----------------------------------------------------->
        @foreach($bedData as $hospcode => $data)
        @php
          $c = $hospColors[$hospcode] ?? $paletteList[$loop->index % count($paletteList)];
        @endphp
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-hover glass p-3 h-100" style="background: #ffffff !important; border: 1px solid var(--glass-bd) !important; border-left: 6px solid {{ $c['border'] }} !important; box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;">

                <!-- หัวข้อ Card -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1 fw-bold" style="color: {{ $c['text'] }};">
                            ข้อมูลเตียง{{ $data['hospname'] }}
                        </h6>
                        @if(!empty($data['updated_at']))
                            <small class="text-muted d-block" style="font-size: 0.73rem;">
                                <i class="fa-regular fa-clock me-1 text-secondary"></i>อัปเดต {{ \Carbon\Carbon::parse($data['updated_at'])->locale('th')->isoFormat('D MMM YYYY H:mm') }} น.
                            </small>
                        @else
                            <small class="text-muted d-block" style="font-size: 0.73rem;">
                                <i class="fa-regular fa-clock me-1 text-secondary"></i>ยังไม่มีข้อมูล
                            </small>
                        @endif
                    </div>
                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0 ms-2" style="width: 35px; height: 35px; background: {{ $c['icon_bg'] }};">
                      <i class="fa-solid fa-bed-pulse fs-5" style="color: {{ $c['border'] }} !important;"></i>
                    </div>
                </div>
                <!-- Header -->
                <div class="row mb-1">
                    <div class="col-4 small text-secondary">แผนก</div>
                    <div class="col-2 small text-secondary text-center">จำนวนเตียง</div>
                    <div class="col-2 small text-secondary text-center">Admit</div>
                    <div class="col-2 small text-secondary text-center">เตียงว่าง</div>
                    <div class="col-2 small text-secondary text-center">อัตราใช้เตียง</div>
                </div>
                <hr class="my-2" style="border-top: 1px solid rgba(0,0,0,0.15); opacity: 1; margin: 6px 0;">
                <!-- รายการเตียงแต่ละแผนก -->
                @foreach($data['beds'] as $b)
                    @php 
                        $empty = $b->bed_qty - $b->bed_use;
                    @endphp
                    <div class="row mb-1 small align-items-center">
                        <div class="col-4 fw-bold">
                            {{ $b->bed_name }}
                        </div>
                        <div class="col-2 text-center fw-bold">
                            {{ $b->bed_qty }}
                        </div>
                        <div class="col-2 text-center fw-bold text-danger">
                            {{ $b->bed_use }}
                        </div>
                        <div class="col-2 text-center fw-bold text-success">
                            {{ $empty }}
                        </div>
                        <!-- อัตราครองเตียงพร้อมสี (เขียว / ส้ม / แดง) -->
                        <div class="col-2 text-center fw-bold"
                            @if($b->bed_rate >= 80)
                                style="color:#f43f5e;"      {{-- แดง (สูง) --}}
                            @elseif($b->bed_rate >= 60)
                                style="color:#f59e0b;"      {{-- ส้ม (ปานกลาง) --}}
                            @else
                                style="color:#10b981;"      {{-- เขียว (ปกติ) --}}
                            @endif
                        >
                            {{ $b->bed_rate }}%
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach        
      </div>
    </div>
  </section>

  <hr>

  {{-- เลือกปีงบประมาณ ----------------------------------------------------------------------------------------------------------}}
  <section id="summary" class="pb-2">
      <div class="container-fluid">
        <form method="POST" action="{{ route('web.index') }}" enctype="multipart/form-data">
        @csrf
          <div class="row g-4 align-items-center">
            <div class="col-lg-9">          
              <h6 class="text-success mb-2"><strong></strong></h6>          
            </div>
            {{-- ขวาสุด: select + ปุ่ม ติดกันและชิดขวา --}}
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

  {{-- ข้อมูลบริการ----------------------------------------------------------------------------------------------------------}}
  <section id="hospital" class="pb-2">
    <div class="container-fluid">
    
      <!-- NAV PILLS (ปุ่มโรงพยาบาลสไตล์โมเดิร์นพร้อมไอคอน) -->
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
          $ipd_records = $data['ipd'];
          $config = DB::table('hospital_config')->where('hospcode', $hospcode)->first();
          $bed_report = $config->bed_report ?? 30;
        @endphp
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pane-{{ $hospcode }}" role="tabpanel" aria-labelledby="tab-{{ $hospcode }}" tabindex="0">          
          <!-- IPD -->
          <div class="glass p-3" style="background: rgba(255,255,255,0.85) !important;">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="fw-bold"><i class="fa-solid fa-hospital-user text-primary me-2"></i>[{{ $hospcode }}] ข้อมูลบริการผู้ป่วยใน IPD {{ $data['hospname'] }} ปีงบประมาณ {{$budget_year}}</h6>
              <div class="d-flex align-items-center gap-2">
                <span class="text-secondary small">Update {{ $data['update_at'] ?? '-' }}</span>
              </div>
            </div>

            <!-- 4 ApexCharts Minimal Style Cards -->
            <div class="row mt-3">
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden card-chart-blue">
                  <div class="card-header py-2">
                    <h6 class="text-center fw-bold mb-0">📈 จำนวน AN</h6>
                  </div>
                  <div class="card-body">
                    <div id="an_chart_{{ $hospcode }}"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden card-chart-green">
                  <div class="card-header py-2">
                    <h6 class="text-center fw-bold mb-0">📈 อัตราครองเตียง (%)</h6>
                  </div>
                  <div class="card-body">
                    <div id="bed_occupancy_{{ $hospcode }}"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden card-chart-orange">
                  <div class="card-header py-2">
                    <h6 class="text-center fw-bold mb-0">📊 AdjRW</h6>
                  </div>
                  <div class="card-body">
                    <div id="adjrw_chart_{{ $hospcode }}"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden card-chart-red">
                  <div class="card-header py-2">
                    <h6 class="text-center fw-bold mb-0">📊 CMI</h6>
                  </div>
                  <div class="card-body">
                    <div id="cmi_chart_{{ $hospcode }}"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Export Buttons & Table -->
            <div class="d-flex justify-content-end mb-2">
              <div id="btn-{{ $hospcode }}-ipd"></div>
            </div>
            <div class="table-responsive">
              <table id="table{{ $hospcode }}_ipd" class="table custom-table my-3" width="100%">
                <thead>
                  <tr>
                    <th class="th-grey" rowspan="2" width="4%">เดือน</th>
                    <th class="th-blue" rowspan="2">จำนวน AN</th>
                    <th class="th-blue" rowspan="2">วันนอนรวม</th> 
                    <th class="th-green" rowspan="2">อัตราครองเตียง (%)</th>
                    <th class="th-green" rowspan="2">Active Base (เตียง)</th>       
                    <th class="th-orange" rowspan="2">AdjRW</th>  
                    <th class="th-orange" rowspan="2">CMI</th>
                    <th class="th-purple" colspan="3">ค่ารักษาพยาบาล</th>                
                  </tr>    
                  <tr> 
                    <th class="th-purple">ค่ารักษารวม</th>
                    <th class="th-purple">ค่า Lab</th>
                    <th class="th-purple">ค่า ยา</th>                 
                  </tr>    
                </thead>
                <tbody>
                  @php 
                    $sum_an_total = 0; 
                    $sum_admdate = 0;   
                    $sum_adjrw = 0; 
                    $sum_inc_total = 0;  
                    $sum_inc_lab_total = 0;
                    $sum_inc_drug_total = 0;
                  @endphp
                  @foreach($ipd_records as $row) 
                  <tr>
                    <td align="center">{{ $row->month }}</td>
                    <td align="right">{{ number_format($row->an_total) }}</td>
                    <td align="right">{{ number_format($row->admdate) }}</td>
                    <td align="right" class="fw-bold text-success">{{ number_format($row->bed_occupancy, 2) }}%</td>
                    <td align="right">{{ number_format($row->active_bed, 2) }}</td>
                    <td align="right">{{ number_format($row->adjrw, 4) }}</td>
                    <td align="right" class="text-primary">{{ number_format($row->cmi, 2) }}</td>
                    <td align="right">{{ number_format($row->inc_total, 2) }}</td>
                    <td align="right">{{ number_format($row->inc_lab_total, 2) }}</td>
                    <td align="right">{{ number_format($row->inc_drug_total, 2) }}</td>
                  </tr>
                  @php 
                    $sum_an_total += $row->an_total; 
                    $sum_admdate += $row->admdate; 
                    $sum_adjrw += $row->adjrw;
                    $sum_inc_total += $row->inc_total; 
                    $sum_inc_lab_total += $row->inc_lab_total; 
                    $sum_inc_drug_total += $row->inc_drug_total;
                  @endphp
                  @endforeach 
                  @php                   
                    $sum_bed_occupancy = ($sum_admdate > 0 && $bed_report > 0 && $diff_days > 0) ? round(($sum_admdate * 100) / ($bed_report * $diff_days), 2) : 0;  
                    $sum_active_bed = ($sum_admdate > 0 && $diff_days > 0) ? round($sum_admdate / $diff_days, 2) : 0;
                    $sum_cmi = ($sum_an_total > 0) ? round($sum_adjrw / $sum_an_total, 2) : 0; 
                  @endphp   
                  <tr class="tr-total">
                    <td align="center">รวม</td>
                    <td align="right">{{ number_format($sum_an_total) }}</td>
                    <td align="right">{{ number_format($sum_admdate) }}</td>
                    <td align="right">{{ number_format($sum_bed_occupancy, 2) }}%</td>     
                    <td align="right">{{ number_format($sum_active_bed, 2) }}</td>   
                    <td align="right">{{ number_format($sum_adjrw, 4) }}</td>  
                    <td align="right" class="text-primary">{{ number_format($sum_cmi, 2) }}</td> 
                    <td align="right">{{ number_format($sum_inc_total, 2) }}</td>
                    <td align="right">{{ number_format($sum_inc_lab_total, 2) }}</td>
                    <td align="right">{{ number_format($sum_inc_drug_total, 2) }}</td>
                  </tr>   
                </tbody>
              </table>
            </div>
          </div>
          <br>
        </div>
        @endforeach

      </div>
    </div>
  </section>

@endsection

@push('scripts')
  {{-- ApexCharts Library --}}
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

  {{-- Interactive Script for Bed Detail Modal --}}
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const hospitalList = document.getElementById('hospital-list');
      const bedDetail = document.getElementById('bed-detail');
      const btnBack = document.getElementById('btn-back');
      const tbody = document.querySelector('#bedDetailTable tbody');
      const sumBed = document.getElementById('sum-bed');
      const sumUse = document.getElementById('sum-use');
      const sumEmpty = document.getElementById('sum-empty');
      const sumRate = document.getElementById('sum-rate');
      const hospNameEl = document.getElementById('modal-hospname');

      // คลิกชื่อโรงพยาบาลเพื่อดูรายละเอียดเตียง
      document.addEventListener('click', function (e) {
        const link = e.target.closest('.hosp-detail-link');
        if (!link) return;

        e.preventDefault();
        const hospcode = link.dataset.hospcode;
        const hospname = link.dataset.hospname;

        hospNameEl.innerText = hospname;
        tbody.innerHTML = `<tr><td colspan="6" class="text-muted">กำลังโหลดข้อมูล...</td></tr>`;

        fetch(`{{ url('web/bed_dep') }}/${hospcode}`)
          .then(res => {
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            return res.json();
          })
          .then(data => {
            tbody.innerHTML = '';

            if (data.beds && data.beds.length > 0) {
              data.beds.forEach(b => {
                const empty = b.bed_qty - b.bed_use;
                let rateColor = 'text-success';
                if (b.bed_rate >= 80) rateColor = 'text-danger fw-bold';
                else if (b.bed_rate >= 60) rateColor = 'text-warning fw-bold';

                tbody.innerHTML += `
                  <tr>
                    <td class="text-center">${b.bed_code}</td>
                    <td class="text-start">${b.bed_name ?? '-'}</td>
                    <td class="text-end">${b.bed_qty}</td>
                    <td class="text-end text-danger">${b.bed_use}</td>
                    <td class="text-end text-success">${empty}</td>
                    <td class="text-end ${rateColor}">${b.bed_rate}%</td>
                  </tr>`;
              });
            } else {
              tbody.innerHTML = `<tr><td colspan="6" class="text-muted">ไม่พบข้อมูลเตียง</td></tr>`;
            }

            sumBed.innerText = (data.summary?.total || 0).toLocaleString();
            sumUse.innerText = (data.summary?.used || 0).toLocaleString();
            sumEmpty.innerText = (data.summary?.empty || 0).toLocaleString();
            sumRate.innerText = `${data.summary?.rate || 0}%`;

            hospitalList.style.display = 'none';
            bedDetail.style.display = 'block';
          })
          .catch(err => {
            console.error("❌ Fetch error:", err);
            tbody.innerHTML = `<tr><td colspan="6" class="text-danger">โหลดข้อมูลไม่สำเร็จ</td></tr>`;
          });
      });

      // ปุ่มกลับ
      if (btnBack) {
        btnBack.addEventListener('click', () => {
          bedDetail.style.display = 'none';
          hospitalList.style.display = 'block';
        });
      }
    });
  </script>

  {{-- Dynamic ApexCharts & DataTables Rendering for all Hospitals --}}
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const hospitalsData = {
        @foreach($hospitalData as $hospcode => $data)
        "{{ $hospcode }}": {
          hospname: @json($data['hospname']),
          months: @json(collect($data['ipd'])->pluck('month')),
          an_total: @json(collect($data['ipd'])->pluck('an_total')),
          adjrw: @json(collect($data['ipd'])->pluck('adjrw')),
          bed_occupancy: @json(collect($data['ipd'])->pluck('bed_occupancy')),
          cmi: @json(collect($data['ipd'])->pluck('cmi'))
        },
        @endforeach
      };

      const commonAreaChartOptions = (seriesName, categories, data, color, unit, formatFn) => ({
        series: [{ name: seriesName, data: data }],
        chart: {
          height: 250,
          type: 'area',
          toolbar: { show: false },
          animations: { enabled: true, easing: 'easeinout', speed: 800 }
        },
        colors: [color],
        markers: { size: 4 },
        fill: {
          type: "gradient",
          gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.4, stops: [0, 90, 100] }
        },
        stroke: { curve: 'smooth', width: 2 },
        dataLabels: {
          enabled: true,
          formatter: formatFn,
          style: { fontSize: '11px', colors: [color] },
          background: { enabled: true, foreColor: '#fff', borderRadius: 2 }
        },
        xaxis: {
          categories: categories,
          labels: { style: { fontSize: '13px' } }
        },
        yaxis: {
          title: { text: unit },
          labels: { formatter: val => val ? Math.round(val).toLocaleString('th-TH') : 0 }
        }
      });

      Object.entries(hospitalsData).forEach(([code, h]) => {
        // 1. Chart AN
        const anEl = document.querySelector("#an_chart_" + code);
        if (anEl) {
          new ApexCharts(anEl, commonAreaChartOptions('จำนวน AN', h.months, h.an_total, '#2563eb', 'ราย', val => val ? Math.round(val).toLocaleString('th-TH') : '')).render();
        }

        // 2. Chart Bed Occupancy
        const bedEl = document.querySelector("#bed_occupancy_" + code);
        if (bedEl) {
          new ApexCharts(bedEl, commonAreaChartOptions('อัตราครองเตียง (%)', h.months, h.bed_occupancy, '#10b981', 'ร้อยละ (%)', val => val ? parseFloat(val).toFixed(1) + '%' : '')).render();
        }

        // 3. Chart AdjRW
        const adjrwEl = document.querySelector("#adjrw_chart_" + code);
        if (adjrwEl) {
          new ApexCharts(adjrwEl, commonAreaChartOptions('AdjRW', h.months, h.adjrw, '#d97706', 'AdjRW', val => val ? parseFloat(val).toFixed(2) : '')).render();
        }

        // 4. Chart CMI
        const cmiEl = document.querySelector("#cmi_chart_" + code);
        if (cmiEl) {
          new ApexCharts(cmiEl, commonAreaChartOptions('CMI', h.months, h.cmi, '#ef4444', 'ค่า CMI', val => val ? parseFloat(val).toFixed(2) : '')).render();
        }

        // 5. DataTables
        const tableEl = $('#table' + code + '_ipd');
        if (tableEl.length && $.fn.DataTable) {
          const dt = tableEl.DataTable({
            dom: 'rt',
            ordering: false,
            paging: false,
            info: false,
            lengthChange: false,
            language: { search: "ค้นหา:" },
            buttons: [{
              extend: 'excelHtml5',
              text: '<i class="bi bi-file-earmark-excel"></i> Excel',
              className: 'btn btn-success btn-sm rounded-pill px-3',
              title: 'ข้อมูลบริการผู้ป่วยใน IPD ' + h.hospname
            }]
          });
          dt.buttons().container().appendTo('#btn-' + code + '-ipd');
        }
      });

      // Recalculate chart dimensions when switching tab
      document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', () => {
          window.dispatchEvent(new Event('resize'));
        });
      });
    });
  </script>
@endpush
