<?php namespace App\Entities;

use Myth\Auth\Entities\User as MythUser;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Gregwar\Image\Image;

class User extends MythUser
{
	/**
     * Default attributes.
     * @var array
     */
    protected $attributes = [
    	'firstname' => 'Anonimous',
    	'lastname'  => 'User',
    ];

	/**
	 * Returns a full name: "first last"
	 *
	 * @return string
	 */
	public function getName()
	{
		return trim(trim($this->attributes['firstname']) . ' ' . trim($this->attributes['lastname']));
	}

	public Function generateMemberId()
	{
		$this->attributes['memberid'] = time() + rand(10,99);

		$qr = Builder::create()
			-> writer(new PngWriter())
			-> writerOptions([])
			-> data($this->attributes['memberid'])
			-> encoding(new Encoding('UTF-8'))
			-> errorCorrectionLevel(new ErrorCorrectionLevelHigh())
			-> size(281)
			-> margin(0)
			-> roundBlockSizeMode(new RoundBlockSizeModeMargin())
			-> validateResult(false)
			-> build();

		$qr->saveToFile(FCPATH.'/images/member/'.$this->attributes['memberid'].'.jpg');

		Image::open(FCPATH.'/images/membercard.jpg')
			-> merge(Image::open(FCPATH.'/images/member/'.$this->attributes['memberid'].'.jpg'), 400, 440, 281, 281)
			-> save(FCPATH.'/images/member/'.$this->attributes['memberid'].'-membercard.jpg');

		unlink(FCPATH.'/images/member/'.$this->attributes['memberid'].'.jpg');

		$this->attributes['membercard'] = $this->attributes['memberid'].'-membercard.jpg';

		return $this;
	}
}