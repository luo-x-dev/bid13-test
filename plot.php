<?php
//Before run this code, please enable GD Library in XAMPP

// Read CSV file and store x, y values in an array
$csvFile = 'data.csv';
$data = [];

if (($handle = fopen($csvFile, 'r')) !== false) {
    fgetcsv($handle); // Skip header row
    while (($row = fgetcsv($handle)) !== false) {
        $data[] = [(int)$row[0], (int)$row[1]];
    }
    fclose($handle);
}

// Image dimensions
$width = 500;
$height = 500;

// Create an image
$image = imagecreatetruecolor($width, $height);

// Colors
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$red = imagecolorallocate($image, 255, 0, 0);

// Fill background
imagefill($image, 0, 0, $white);

// Find min/max values for scaling
$x_min = min(array_column($data, 0));
$x_max = max(array_column($data, 0));
$y_min = min(array_column($data, 1));
$y_max = max(array_column($data, 1));

// Scaling function
function scale($value, $min, $max, $img_min, $img_max) {
    return $img_min + ($img_max - $img_min) * ($value - $min) / ($max - $min);
}

// Draw axes
imageline($image, 50, 450, 450, 450, $black); // X-axis
imageline($image, 50, 450, 50, 50, $black); // Y-axis

// Plot points
foreach ($data as $point) {
    $x = scale($point[0], $x_min, $x_max, 50, 450);
    $y = scale($point[1], $y_min, $y_max, 450, 50); // Invert Y to match graph convention
    imagefilledellipse($image, $x, $y, 5, 5, $red);
}

// Output image
header('Content-Type: image/png');
imagepng($image);
// imagedestroy($image);

// Save the image as plot.png
$outputFile = 'plot.png';
if (imagepng($image, $outputFile)) {
    echo "Scatter plot saved successfully as $outputFile";
} else {
    echo "Error saving the scatter plot.";
}

imagedestroy($image);
?>
