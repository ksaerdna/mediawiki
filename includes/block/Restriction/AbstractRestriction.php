<?php
/**
 * Abstract block restriction.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

namespace MediaWiki\Block\Restriction;

abstract class AbstractRestriction implements Restriction {

	/**
	 * @var string
	 */
	const TYPE = '';

	/**
	 * @var int
	 */
	const TYPE_ID = 0;

	/**
	 * @var int
	 */
	protected $blockId;

	/**
	 * @var int
	 */
	protected $value;

	/**
	 * Create Restriction.
	 *
	 * @since 1.33
	 * @param int $blockId
	 * @param int $value
	 */
	public function __construct( $blockId, $value ) {
		$this->blockId = (int)$blockId;
		$this->value = (int)$value;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getType() {
		return static::TYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getTypeId() {
		return static::TYPE_ID;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockId() {
		return $this->blockId;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setBlockId( $blockId ) {
		$this->blockId = (int)$blockId;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function newFromRow( \stdClass $row ) {
		return new static( $row->ir_ipb_id, $row->ir_value );
	}

	/**
	 * {@inheritdoc}
	 */
	public function toRow() {
		return [
			'ir_ipb_id' => $this->getBlockId(),
			'ir_type' => $this->getTypeId(),
			'ir_value' => $this->getValue(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function equals( Restriction $other ) {
		return $this->getHash() === $other->getHash();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHash() {
		return $this->getType() . '-' . $this->getValue();
	}
}
