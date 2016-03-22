<div class="ss-diagnostic-block">
    <h3><?php echo t('settings.php status') ?></h3>
    <ul class="ss-config-diagnostic">
        <?php if (!empty($data['data']['diagnostic'])): ?>
            <?php foreach ($data['data']['diagnostic'] as $d_item): ?>
                <li><?php echo $d_item ?></li>
            <?php endforeach ?>
        <?php else: ?>
            <h4 class="ss-ok">OK</h4>
        <?php endif ?>
    </ul>
</div>
<?php
if (!empty($data['data']['diagnostic'])): ?>
<div class="ss-config-block">
<p><?php echo t("Insert this configuration code (start-end block) at the end of your settings.php") ?>:</p>
<pre class="code-ss-inlcude">
<span class="code-comments">// StackSight start config</span>
<span class="code-red">define</span>(<span class="code-yellow">'DRUPAL_ROOT'</span>, <span class="code-yellow">getcwd()</span>);
<span class="code-red">define</span>(<span class="code-yellow">'STACKSIGHT_APP_ID'</span>, <span class="pre-code-red">'<?php echo $data['data']['_id'] ?>'</span>);
<span class="code-red">define</span>(<span class="code-yellow">'STACKSIGHT_TOKEN'</span>, <span class="pre-code-red">'<?php echo $data['data']['token'] ?>'</span>);
<span class="code-red">require_once</span>(<span class="code-blue">DRUPAL_ROOT</span> . <span class="pre-code-red">'/<?php echo $data['data']['module_path']; ?>'</span> . <span class="code-yellow">'/stacksight-php-sdk/bootstrap-drupal-6.php'</span>);
<span class="code-comments">// StackSight end config</span>
</pre>
</div>
<?php endif ?>