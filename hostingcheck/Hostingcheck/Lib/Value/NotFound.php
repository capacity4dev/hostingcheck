<?php
/**
 * Hostingcheck (https://github.com/zero2one/hostingcheck)
 *
 * @link      https://github.com/zero2one/hostingcheck source repository.
 * @copyright Copyright (c) 2014 Serial Graphics (http://serial-graphics.be)
 * @license   http://opensource.org/licenses/GPL-2.0 GNU Public License
 */


/**
 * Value that indicates that the requested value is not found.
 *
 * @author Peter Decuyper <peter@serial-graphics.be>
 */
class Hostingcheck_Value_NotFound extends Hostingcheck_Value_Abstract
{
    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        $value = $this->getValue();
        return (empty($value))
            ? 'Not Found'
            : (string) $this->getValue();
    }
}