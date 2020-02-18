<?php
if (isset($_GET['a'])) $a = $_GET['a']; else $a = 'IDLE';

// Create $colors array
$colors['IDLE'] = array(
  'R' => 128,
  'G' => 128,
  'B' => 128,
);
$colors['STATUS_A'] = array(
  'R' => 0,
  'G' => 255,
  'B' => 0,
);
$colors['STATUS_B'] = array(
  'R' => 255,
  'G' => 180,
  'B' => 0,
);
$colors['STATUS_C'] = array(
  'R' => 255,
  'G' => 0,
  'B' => 0,
);
$colors['STATUS_D'] = array(
  'R' => 128,
  'G' => 128,
  'B' => 255,
);
$colors['STATUS_E'] = array(
  'R' => 0,
  'G' => 255,
  'B' => 255,
);

// Create empty mixer image big, so we can copy resampled to force anti-aliasing
$mixer_big = imagecreatetruecolor(100, 150);

// Create empty final mixer image
$mixer = imagecreatetruecolor(25, 35);

// Load bare truck image (white overlay)
$truck = imagecreatefrompng('truck_bare.png');

// Turn in alpha channel in destination image
imagesavealpha( $mixer, true );

// Fill both images with transparant background
imagefill($mixer_big, 0, 0, imagecolortransparent($mixer_big));
imagefill($mixer, 0, 0, imagecolortransparent($mixer));

// Create color by request
$color = imagecolorallocate($mixer_big, $colors[$a]['R'], $colors[$a]['G'], $colors[$a]['B']);

// Create circle
imagefilledellipse($mixer_big, 50, 50, 100, 100, $color);

// Add tip to the circle, creating the location marker drop shape
$points = array(7,75,93,75,50,150);
imagefilledpolygon($mixer_big, $points, 3, $color);

// Merge drop with bare truck
imagecopy($mixer_big, $truck, 12, 30, 0, 0, 75, 50);

// Resample mixer big to final mixer image for anti-aliasing
imagecopyresampled($mixer, $mixer_big, 0, 0, 0, 0, 25, 35, 100, 150);

// Output final image to browser as png
header('Content-Type: image/png');
imagepng($mixer);
?>