<div class="panel">
    <div class="panel-body">
        {if $phpSupported}
            <div class="alert alert-info">
                {l s='Your thirty bees is using this module to detect whehter thet client is connecting to your store using mobile or table device.' mod='tbdetectmobile'}
                <br>
                {l s='Your store can return different response for mobile users. For example, you can allow some modules to run in desktop mode only.' mod='tbdetectmobile'}
            </div>
        {else}
            <div class="alert alert-danger">
                <b>{$phpVersionError}</b>
                <br>
                {l s='We strongly recommend you upgrade your server to use newer PHP version.' mod='tbdetectmobile'}
                <br>
                {l s='If you are unable to do so, you can download older version of this module that run on your platform from [1]github[/1]' mod='tbdetectmobile' tags=["<a href='https://github.com/thirtybees/tbdetectmobile/releases'>"]}
            </div>
        {/if}
    </div>
</div>