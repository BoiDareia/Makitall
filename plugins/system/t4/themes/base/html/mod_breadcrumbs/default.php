<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

?>
<nav role="navigation" aria-label="<?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?>">
	<ol itemscope itemtype="https://schema.org/BreadcrumbList" class="mod-breadcrumbs breadcrumb">
		<?php if ($params->get('showHere', 1)) : ?>
			<li>
				<?php echo Text::_('MOD_BREADCRUMBS_HERE'); ?>&#160;
			</li>
		<?php else : ?>
			<li class="active">
				<span class="icon fa fa-home"></span>
			</li>
		<?php endif; ?>

		<?php
		// Get rid of duplicated entries on trail including home page when using multilanguage
		for ($i = 0; $i < $count; $i++)
		{
			if ($i === 1 && empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link === $list[$i - 1]->link)
			{
				unset($list[$i]);
			}
		}

		// Find last and penultimate items in breadcrumbs list
		end($list);
		$last_item_key   = key($list);
		prev($list);
		$penult_item_key = key($list);

		// Make a link if not the last item in the breadcrumbs
		$show_last = $params->get('showLast', 1);

		// Generate the trail
		foreach ($list as $key => $item) :
			if ($key !== $last_item_key) :
				if (!empty($item->link)) :
					$breadcrumbItem = '<a itemprop="item" href="' . $item->link . '" class="pathway"><span itemprop="name">' . $item->name . '</span></a>';
				else :
					$breadcrumbItem = '<span itemprop="name">' . $item->name . '</span>';
				endif;
				// Render all but last item - along with separator ?>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="mod-breadcrumbs__item breadcrumb-item"><span property="item" typeof="WebPage"><?php echo $breadcrumbItem; ?></span>
				<?php if (!empty($separator)) : ?>
						<span class="divider">
							<?php echo $separator; ?>
						</span>
					<?php else:?>
							<span class="divider"></span>
					<?php endif; ?>

					<meta itemprop="position" content="<?php echo $key + 1; ?>">
				</li>
			<?php elseif ($show_last) :
				$breadcrumbItem = '<span itemprop="name">' . $item->name . '</span>';
				// Render last item if reqd. ?>
				<li aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="mod-breadcrumbs__item breadcrumb-item active"><?php echo $breadcrumbItem; ?>
					<meta itemprop="position" content="<?php echo $key + 1; ?>">
				</li>
			<?php endif;
		endforeach; ?>
	</ol>
</nav>
