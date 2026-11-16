{{-- MODALS FOR REFER DASHBOARD --}}

{{-- 1. Refer Out วันนี้ --}}
<div class="modal fade" id="ReferOutDetailModal" tabindex="-1" aria-labelledby="referOutLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #d32f2f, #ef5350);">
        <h5 class="modal-title fw-bold" id="referOutLabel">
          <i class="fa-solid fa-truck-arrow-right me-2"></i> Refer Out วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#ffebee;">
            <tr class="text-center text-danger fw-semibold">
              <th rowspan="2" class="align-middle">รหัส</th>
              <th rowspan="2" class="align-middle">ชื่อโรงพยาบาล</th>
              <th colspan="2" style="border-right:1px solid #ffcdd2;">OPD</th>
              <th colspan="2">IPD</th>
            </tr>
            <tr class="text-center text-danger fw-semibold">
              <th>ในจังหวัด</th>
              <th style="border-right:1px solid #ffcdd2;">ต่างจังหวัด</th>
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
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
                  </small>
                </td>
                <td align="right" class="text-primary">{{ number_format($h->visit_referout_inprov) }}</td>
                <td align="right" class="text-success">{{ number_format($h->visit_referout_outprov) }}</td>
                <td align="right" class="text-primary">{{ number_format($h->visit_referout_inprov_ipd) }}</td>
                <td align="right" class="fw-bold text-danger">{{ number_format($h->visit_referout_outprov_ipd) }}</td>
              </tr>
            @endforeach
            <tr style="background-color:#eef4fb;" class="fw-bold text-end">
              <td colspan="2" class="text-center text-dark">รวมทั้งหมด</td>
              <td class="text-primary">{{ number_format($hospitalSummary->sum('visit_referout_inprov')) }}</td>
              <td class="text-success">{{ number_format($hospitalSummary->sum('visit_referout_outprov')) }}</td>
              <td class="text-primary">{{ number_format($hospitalSummary->sum('visit_referout_inprov_ipd')) }}</td>
              <td class="text-danger">{{ number_format($hospitalSummary->sum('visit_referout_outprov_ipd')) }}</td>
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

{{-- 2. Refer In วันนี้ --}}
<div class="modal fade" id="ReferInDetailModal" tabindex="-1" aria-labelledby="referInLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #0d47a1, #1976d2);">
        <h5 class="modal-title fw-bold" id="referInLabel">
          <i class="fa-solid fa-truck-medical me-2"></i> Refer In วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#e3f2fd;">
            <tr class="text-center text-primary fw-semibold">
              <th rowspan="2" class="align-middle">รหัส</th>
              <th rowspan="2" class="align-middle">ชื่อโรงพยาบาล</th>
              <th colspan="2" style="border-right:1px solid #bbdefb;">OPD</th>
              <th colspan="2">IPD</th>
            </tr>
            <tr class="text-center text-primary fw-semibold">
              <th>ในจังหวัด</th>
              <th style="border-right:1px solid #bbdefb;">ต่างจังหวัด</th>
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
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
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
        <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

{{-- 3. Refer Back วันนี้ --}}
<div class="modal fade" id="ReferBackDetailModal" tabindex="-1" aria-labelledby="referBackLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3" style="background-color:#f5f8fc;">
      <div class="modal-header text-white rounded-top-3" style="background: linear-gradient(135deg, #1b5e20, #2e7d32);">
        <h5 class="modal-title fw-bold" id="referBackLabel">
          <i class="fa-solid fa-arrow-rotate-left me-2"></i> Refer Back วันนี้
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <table class="table table-hover align-middle shadow-sm rounded-3 overflow-hidden mb-0" style="background-color: #ffffff; border-radius: 0.75rem;">
          <thead style="background-color:#e8f5e9;">
            <tr class="text-center text-success fw-semibold">
              <th class="align-middle">รหัส</th>
              <th class="align-middle">ชื่อโรงพยาบาล</th>
              <th style="border-right:1px solid #c8e6c9;">ในจังหวัด</th>
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
                    {{ $h->last_updated_at ? \Carbon\Carbon::parse($h->last_updated_at)->locale('th')->isoFormat('D MMM YYYY H:mm') . ' น.' : 'ยังไม่มีข้อมูลส่ง' }}
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
        <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
