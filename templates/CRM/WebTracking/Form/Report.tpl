{* https://civicrm.org/licensing *}

<div id='EmbedAPI'>
  <aside class="Header-auth" id="header-auth">
    <div class="Header-embedApi" id="embed-api-auth-container"></div>
    <a class="Header-logout" href="https://accounts.google.com/logout">Logout</a>
  </aside>

  <div class="Content">
    <div class="Dashboard Dashboard--full">
      <header class="Dashboard-header">
        <ul class="FlexGrid">
          <li class="FlexGrid-item">
            <div class="Titles">
              <h1 class="Titles-main" id="view-name">Dashboard</h1>
            </div>
          </li>
          <li class="FlexGrid-item FlexGrid-item--fixed">
            <div id="active-users-container">
              <div class="ActiveUsers">
                "Active Users: "
                <b class="ActiveUsers-value"></b>
              </div>
            </div>
          </li>
        </ul>
        <div class="ViewSelector" id="view-selector-container"></div>
      </header>

      <ul class="FlexGrid FlexGrid--halves">
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Top Countries</h1>
            <div class="Titles-sub">By sessions</div>
          </header>
          <div id="country-view-container"></div>
        </li>
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Top Traffic Sources</h1>
            <div class="Titles-sub">By sessions</div>
          </header>
          <div id="source-view-container"></div>
        </li>
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Top Events</h1>
            <div class="Titles-sub">By total events</div>
          </header>
          <div id="event-view-container"></div>
        </li>
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Top Affiliations</h1>
            <div class="Titles-sub">By revenue</div>
          </header>
          <div id="transaction-view-container" margin="1em 0em 0em 0em"></div>
        </li>
        <li class="FlexGrid-item">
          <header class="Titles">
            <h1 class="Titles-main">Page Views</h1>
            <div class="Titles-sub">By date</div>
          </header>
          <div id="page-view-container"></div>
          <div id="date-range-selector-container"></div>
        </li>
      </ul>
    </div>
  </div>
</div>
