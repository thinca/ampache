<?php
/*
 * vim:set softtabstop=4 shiftwidth=4 expandtab:
 *
 *  LICENSE: GNU Affero General Public License, version 3 (AGPL-3.0-or-later)
 * Copyright 2001 - 2020 Ampache.org
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

declare(strict_types=0);

namespace Ampache\Module\Application\Artist;

use Ampache\Config\ConfigContainerInterface;
use Ampache\Module\Application\ApplicationActionInterface;
use Ampache\Module\Util\Ui;
use Ampache\Module\Util\UiInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateFromTagsAction implements ApplicationActionInterface
{
    public const REQUEST_KEY = 'update_from_tags';

    private ConfigContainerInterface $configContainer;

    private UiInterface $ui;

    public function __construct(
        ConfigContainerInterface $configContainer,
        UiInterface $ui
    ) {
        $this->configContainer = $configContainer;
        $this->ui              = $ui;
    }

    public function run(ServerRequestInterface $request): ?ResponseInterface
    {
        $this->ui->showHeader();
        
        $type       = 'artist';
        $object_id  = (int) filter_input(INPUT_GET, 'artist', FILTER_SANITIZE_NUMBER_INT);
        $target_url = sprintf(
            '%s/artists.php?action=show&amp;artist=%d',
            $this->configContainer->getWebPath(),
            $object_id
        );
        require_once Ui::find_template('show_update_items.inc.php');
        
        $this->ui->showQueryStats();
        $this->ui->showFooter();
        
        return null;
    }
}