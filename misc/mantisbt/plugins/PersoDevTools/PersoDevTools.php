<?php
# MantisBT - a php based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Perso Development Tools Plugin
* @package MantisPlugin
* @subpackage MantisPlugin
* @copyright Copyright (C) 2014 Jonathan Jaubart
* @copyright Copyright (C) 2002 - 2013  MantisBT Team - mantisbt-dev@lists.sourceforge.net
*/

/**
 * requires MantisPlugin.class.php
*/
require_once( config_get( 'class_path' ) . 'MantisPlugin.class.php' );

/**
 * PersoDevTools Class
*/
class PersoDevToolsPlugin extends MantisPlugin {

	/**
	 *  A method that populates the plugin information and minimum requirements.
	 */
	function register( ) {
		$this->name = plugin_lang_get( 'title' );
		$this->description = plugin_lang_get( 'description' );
		$this->page = '';

		$this->version = '1.0';
		$this->requires = array(
				'MantisCore' => '1.2.0',
		);

		$this->author = 'Jonathan Jaubart';
		$this->contact = 'dev@jaubart.com';
	}

	/**
	 * Default plugin configuration.
	 */
	function hooks( ) {
		$hooks = array(
				'EVENT_VIEW_BUG_DETAILS' => 'display_commit_message'
		);
		return $hooks;
	}
	
	function display_commit_message($event, $bugid) {
		if(!$bugid) return;

		$t_fields = config_get( 'bug_view_page_fields' );
		$t_fields = columns_filter_disabled( $t_fields );		
		
		$tpl_show_id = in_array( 'id', $t_fields );
		$tpl_show_description = in_array( 'description', $t_fields );
		$tpl_show_status = in_array( 'status', $t_fields );		
		
		if($tpl_show_id && $tpl_show_description && $tpl_show_status) {
		
			bug_ensure_exists( $bugid );
			$bug = bug_get( $bugid, true );		
			access_ensure_bug_level( VIEWER, $bugid );		
			
			$tpl_description = string_display_links( $bug->summary );
			$tpl_status = get_enum_element( 'status', $bug->status );					
			$tpl_link =  config_get( 'path' ) . string_get_bug_view_url( $bugid, null );
			
			$message = sprintf('%s - #JJ%d: %s<br/>%s',
					strtoupper($tpl_status),
					$bugid,
					$tpl_description,
					$tpl_link
			);		
			
			echo '<tr ', helper_alternate_class(), '>';
			
			echo '<td class="category">', plugin_lang_get( 'commit_message' ), '</td>';
			echo '<td colspan="5">'.$message.'</td>';
			
			echo '</tr>';
		}
	}
	
		
}
