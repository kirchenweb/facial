<?php
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
//
// @Author Karthik Tharavaad
//         karthik_tharavaad@yahoo.com
// @Contributor Maurice Svay
//              maurice@svay.Com
// @Contributor Marijn Ophorst
//              marijn@sensimedia.nl

namespace Sensi\Facial;

use Exception;
use DomainException;

class Detector
{
    /** @var array */
    protected array $detection_data;

    /**
     * Creates a face-detector with the given configuration
     *
     * Configuration can be either passed as an array or as
     * a filepath to a serialized array file-dump
     *
     * @param string|array $detection_data
     * @return void
     * @throws Exception
     */
    public function __construct($detection_data = null)
    {
        if (is_null($detection_data)) {
            $detection_data = dirname(__DIR__).'/resources/detection.dat';
        }
        if (is_array($detection_data)) {
            $this->detection_data = $detection_data;
            return;
        }
    
        if (!is_file($detection_data)) {
            // fallback to same file in this class's directory
            $detection_data = dirname(__FILE__) . DIRECTORY_SEPARATOR . $detection_data;
            
            if (!is_file($detection_data)) {
                throw new Exception("Couldn't load detection data");
            }
        }
        
        $this->detection_data = unserialize(file_get_contents($detection_data));
    }

    /**
     * Create a detectable from a resource.
     *
     * @param resource|GdImage $resource
     * @return Sensi\Facial\Detectable
     */
    public function fromResource($resource) : Detectable
    {
        return new Detectable($this->detection_data, $resource);
    }

    /**
     * Create a detectable from a filename.
     *
     * @param string $file
     * @return Sensi\Facial\Detectable
     */
    public function fromFile(string $file) : Detectable
    {
        if (!is_file($file)) {
            throw new DomainException("$file is not a file");
        }
        $canvas = $this->imageCreateFromExtension($file);

			return new Detectable($this->detection_data, $canvas);
    }

    /**
     * Create a detectable from a (binary) string.
     *
     * @param string $string
     * @return Sensi\Facial\Detectable
     */
    public function fromString(string $string) : Detectable
    {
        $canvas = imagecreatefromstring($file);
        if (!$canvas) {
            throw new DomainException("$string does not contain a valid image");
        }
        return new Detectable($this->detection_data, $canvas);
		}

		protected function imageCreateFromExtension(string $file) : false|\GdImage
		{
				$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
				$extension = match ($extension) {
						'jpg' => 'jpeg',
						default => $extension,
				};
				$function = 'imagecreatefrom'.$extension;
				if (function_exists($function)) {
						return $function($file);
				}
				return false;
		}

}

