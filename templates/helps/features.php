<?php defined('ABSPATH') || exit; ?>

<h2><?php _e( 'Not a feature?', 'wc1c' ); ?></h2>

<p>
    Прежде всего убедитесь, действительно ли требуемая возможность отсутствует.
    Возможно стоит просмотреть доступные настройки или почитать документацию.
</p>

<p>
    Так же, перед запросом возможности, требуется убедиться:
</p>

<ul>
    <li>Не добавлена ли нужная возможность в обновлениях WC1C.</li>
    <li>Не реализована ли возможность дополнительным расширением к WC1C.</li>
</ul>

<p>
    Если возможность добавлена в обновлениях WC1C, нужно просто установить обновленную версию.
</p>

<p>
    А вот если же возможность реализована в расширении к WC1C, то данную возможность не стоит ожидать как часть WC1C
    и нужно устанавливать именно расширение. Потому как реализованнаая в расширении возможность настолько значительная, что для неё потребовалось создавать расширение.
</p>

<p>
	<a href="#" class="button button-primary">
        <?php _e( 'Request a feature', 'wc1c' ); ?>
    </a>
	<a href="https://wc1c.info/features" class="button" target="_blank">
		<?php _e( 'Features', 'wc1c' ); ?>
	</a>
    <a href="https://wc1c.info/extensions" class="button" target="_blank">
		<?php _e( 'Extensions', 'wc1c' ); ?>
    </a>
</p>