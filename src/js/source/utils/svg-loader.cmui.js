const svgWrap = document.createElement('div'),
    svgData = `
  <!-- SVG HOME -->
  <svg style="display: none;">
    <symbol id="svg-home" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" preserveAspectRatio="xMinYMin meet">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
    </symbol>
  </svg>
  <!-- /SVG HOME -->
  
  <!-- SVG USER -->
  <svg style="display: none;">
    <symbol id="svg-user" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" preserveAspectRatio="xMinYMin meet">
      <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
    </symbol>
  </svg>
  <!-- /SVG USER -->
  
  <!-- SVG USER GROUP -->
  <svg style="display: none;">
    <symbol id="svg-user-group" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" preserveAspectRatio="xMinYMin meet">
      <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
    </symbol>
  </svg>
  <!-- /SVG USER GROUP -->
  
  <!-- SVG LINK -->
  <svg style="display: none;">
    <symbol id="svg-link" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" preserveAspectRatio="xMinYMin meet">
      <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
    </symbol>
  </svg>
  <!-- /SVG LINK -->
`;

svgWrap.innerHTML = svgData;
document.body.appendChild(svgWrap);
