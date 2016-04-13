<?php

if (defined('STACKSIGHT_DEBUG') && STACKSIGHT_DEBUG === true) {
    define('STACKSIGHT_DEBUG_MODE', true);
    $_SESSION['stacksight_debug'] = array();
    stacksight_cron();

    if (isset($_SESSION['stacksight_debug']) && !empty($_SESSION['stacksight_debug']) && is_array($_SESSION['stacksight_debug'])) {
        foreach ($_SESSION['stacksight_debug'] as $key => $feature):?>
            <div class="feature-block">
                <h3 class="header">
                    <?php switch ($key) {
                        case 'updates':
                            echo 'Updates';
                            break;
                        case 'health':
                            echo 'Health';
                            break;
                        case 'inventory':
                            echo 'Inventory';
                            break;
                        case 'events':
                            echo 'Events';
                            break;
                        case 'logs':
                            echo 'Logs';
                            break;
                    } ?>
                </h3>
                <hr>
                <div class="connection-info">
                    <?php foreach ($feature['data'] as $key => $feature_detail): ?>
                        <div>
                        <span>
                            Sending type:
                            <span class="header">
                                <?php switch ($feature_detail['type']) {
                                    case 'curl':
                                        echo 'cURL';
                                        break;
                                    case 'multicurl':
                                        echo 'Multi cURL';
                                        break;
                                    case 'sockets':
                                        echo 'Sockets';
                                        break;
                                    case 'threads':
                                        echo 'Threads';
                                        break;
                                }; ?>
                            </span>
                        </span>
                        </div>
                        <div>
                            <?php if ($feature_detail['type'] == 'curl' || $feature_detail['type'] == 'multicurl'): ?>
                                <?php if (isset($feature['request_info']) && !empty($feature['request_info']) && is_array($feature['request_info'])): ?>
                                    <table class="debug-table" cellpadding="0" cellspacing="0">
                                        <tbody>
                                        <?php $i = 0;
                                        foreach ($feature['request_info'] as $key_request => $request_value): ?>
                                            <?php if (in_array($key_request, SSUtilities::getCurlInfoFields())): ++$i; ?>
                                                <tr class="<?php if (($i % 2) == 0) echo 'odd'; else echo 'even'; ?>">
                                                    <th scope="row"><?php echo SSUtilities::getCurlDescription($key_request); ?></th>
                                                    <td>
                                                        <?php
                                                        if (is_array($request_value)) {
                                                            echo implode('<br/>', $request_value);
                                                        } else {
                                                            echo $request_value;
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div class="response">
                                        <strong>Response:</strong>
                                        <?php echo $feature['request_info']['response'] ?>
                                    </div>
                                <?php else: ?>
                                    <table class="debug-table" cellpadding="0" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td>Connect information not found... :(</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($feature_detail['type'] == 'sockets'): ?>
                                <?php if (isset($feature['request_info']) && !empty($feature['request_info']) && is_array($feature['request_info'])): ?>
                                    <?php foreach ($feature['request_info'] as $key_request => $request_value): ?>
                                        <table class="debug-table" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr class="odd">
                                                <th scope="row">
                                                    Result#<?php echo $key_request + 1; ?>:
                                                </th>
                                                <td>
                                                    <?php if ($request_value['error'] == true): ?>
                                                        <strong class="pre-code-red">Error</strong>
                                                    <?php else: ?>
                                                        <strong class="pre-code-green">Success</strong>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <th scope="row">
                                                    Details:
                                                </th>
                                                <td><?php echo $request_value['data']; ?></td>
                                            </tr>
                                            <tr class="odd">
                                                <th scope="row">
                                                    Meta:
                                                </th>
                                                <td><?php print_r($request_value['meta']); ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach;
        foreach ($_SESSION['stacksight_debug'] as $key => $feature):?>
            <div class="feature-block">
                <h3 class="header">
                    <?php switch ($key) {
                        case 'updates':
                            echo 'Updates';
                            break;
                        case 'health':
                            echo 'Health';
                            break;
                        case 'inventory':
                            echo 'Inventory';
                            break;
                        case 'events':
                            echo 'Events';
                            break;
                        case 'logs':
                            echo 'Logs';
                            break;
                    } ?>
                </h3>
                <hr>
                <div class="dump-of-data">
                    <?php if (isset($feature_detail['data']['data']) && !empty($feature_detail['data']['data'])): ?>
                        <pre>
                            <?php print_r($feature_detail['data']['data']); ?>
                        </pre>
                    <?php else: ?>
                        <strong>Data not found... :(</strong>
                    <?php endif; ?>

                </div>
            </div>
        <?php endforeach;
    }
}
