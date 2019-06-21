{* https://civicrm.org/licensing *}

{* Adds social networking buttons (Facebook like, Twitter tweet, Google +1, LinkedIn) to public pages (online contributions, event info) *}

<div class="crm-section crm-socialnetwork help">

    {if $enable_tracking eq 1}
        {assign var=urlTitle value=$title|replace:" ":"_"}
        {assign var=twitterUrl value="`$url`&amp;utm_source=twitter&amp;utm_medium=social&amp;utm_campaign=twitter"}
        {assign var=linkedInUrl value=$url|cat:"&amp;utm_source=linkedin&amp;utm_medium=social&amp;utm_campaign="|cat:$urlTitle}
        {assign var=fbUrl value="`$url`&utm_source=facebook&utm_medium=social&utm_campaign=`$urlTitle`"|replace:'localhost:7979':'bpososdpit.localtunnel.me'|replace:'&amp;':'&'}
        {assign var=googlePlusOneUrl value=$url|cat:"&amp;utm_source=googleplus&amp;utm_medium=social&amp;utm_campaign="|cat:$urlTitle}
        {assign var=emailUrl value=$pageURL|cat:'&amp;utm_source=spreadtheword&amp;utm_medium=email&amp;utm_campaign='|cat:$urlTitle}
    {else}
        {assign var=urlTitle value=$tittle}
        {assign var=twitterUrl value=$url}
        {assign var=linkedInUrl value=$url}
        {assign var=fbUrl value=$url}
        {assign var=googlePlusOneUrl value=$url}
        {assign var=emailUrl value=$url}
    {/if}

    <h3 class="nobackground">{ts}Help spread the word{/ts}</h3>
    <div class="description">
        {ts}Please help us and let your friends, colleagues and followers know about our page{/ts}{if $title}:
        <span class="bold"><a href="{$emailUrl}">{$title}</a></span>
        {else}.{/if}
    </div>
    <div class="crm-fb-tweet-buttons">
        {if $emailMode eq true}
            {*use images for email*}
            <a href="https://twitter.com/share?url={$twitterUrl}&amp;text={$title}" id="crm_tweet">
                <img title="Twitter Tweet Button" src="{$config->userFrameworkResourceURL|replace:'https://':'http://'}/i/tweet.png" width="55px" height="20px"  alt="Tweet Button">
            </a>
            <a href="https://www.facebook.com/plugins/like.php?href={$url}" target="_blank">
                <img title="Facebook Like Button" src="{$config->userFrameworkResourceURL|replace:'https://':'http://'}/i/fblike.png" alt="Facebook Button" />
            </a>
        {else}
            <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
            {*use advanced buttons for pages*}
            <div class="label">
                <iframe allowtransparency="true" frameborder="0" scrolling="no"
                src="https://platform.twitter.com/widgets/tweet_button.html?text={$title}&amp;url={$twitterUrl|replace:'&amp;':'&'|replace:'localhost:7979':'bpososdpit.localtunnel.me'|escape:'url'}"
                style="width:100px; height:20px;">
                </iframe>
            </div>
            <div class="label">
                <g:plusone href={$googlePlusOneUrl}></g:plusone>
            </div>
            <div class="label" style="width:300px;">
                <iframe src="https://www.facebook.com/plugins/like.php?app_id=240719639306341&amp;href={$fbUrl|escape:'url'}&amp;send=false&amp;layout=standard&amp;show_faces=false&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:30px;" allowTransparency="true">
                </iframe>
            </div>
            <div class="label">
              <script src="https://platform.linkedin.com/in.js" type="text/javascript"></script>
              <script type="IN/Share" data-url={$linkedInUrl} data-counter="right"></script>
            </div>
        {/if}
    </div>
    {if $pageURL}
      {if $emailMode neq true}
        <br/>
      {/if}
      <br/>
      <div class="clear"></div>
      <div>
        <span class="bold">{ts}You can also share the below link in an email or on your website.{/ts}</span>
        <br/>
        <a href="{$emailUrl}">{$pageURL}</a>
      </div>
    {else}
      <div class="clear"></div>
    {/if}
</div>


