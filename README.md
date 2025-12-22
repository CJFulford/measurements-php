# measurements-php

## Description

The measurements-php library provides functionality for handling measurements, particularly focusing on length and area
calculations. It offers classes for managing different units of length and area, enabling easy conversion, arithmetic
operations, and formatting.

## Installation

You can install the measurements-php library via Composer. Run the following command in your terminal:

`composer require cjfulford/measurements-php`

## Usage

### Length

#### Length Unit

The LengthUnit class defines various units of length, such as kilometer, meter, centimeter, inch, foot, yard, and mile.

```
use Measurements\Length\LengthUnit;

$kilometer = new LengthUnit(LengthUnit::KILOMETRE);
$meter = new LengthUnit(LengthUnit::METRE);
// ...
```

#### Length Operations

The Length class enables operations on lengths, such as addition, subtraction, multiplication, division, rounding, and
comparison.
There is also a LengthImmutable class which provides the same functionality, but never updates the internal values of an
instance.

```
use Measurements\Length\Length;
use Measurements\Length\LengthUnit;

// Create length instances
$length1 = new Length(5, LengthUnit::METRE);
$length2 = new Length(3, LengthUnit::FOOT);

// Addition
$length = $length1->add($length2);

// Subtraction
$length = $length1->sub($length2);

// Multiplication
$length = $length1->mulByNumber(2);
$area = $length1->mulByLength($length2);

// Division
$length = $length1->divByNumber(2);
$number = $length1->divByLength($length2);

// Rounding
$result = $length1->round(LengthUnit::METRE, 2);

// Comparison
$isEqual = $length1->isEqualTo($length2);
$isGreaterThan = $length1->isGreaterThan($length2, false);
$isLessThan = $length1->isLessThan($length2, false);

// Formatting
$format = $length1->format(LengthUnit:INCH, 2, Format::ACRONYM)
$format = $length1->format(LengthUnit:FOOT, 2, Format::SYMBOL)
$format = $length1->format(LengthUnit:METRE, 2, Format::Name)
```

### Area

#### Area Unit

The AreaUnit class defines various units of area, such as square meter, square kilometer, square inch, square foot, etc.

```
use Measurements\Area\AreaUnit;

$squareMeter = new AreaUnit(AreaUnit::SQUARE_METRE);
$squareKilometer = new AreaUnit(AreaUnit::SQUARE_KILOMETRE);
// ...
```

#### Area Operations

The Area class enables operations on areas, such as addition, subtraction, multiplication, division, and comparison.
There is also an AreaImmutable class which provides the same functionality, but never updates the internal values of an
instance.

```
use Measurements\Area\Area;
use Measurements\Area\AreaUnit;

// Create area instances
$area1 = new Area(100, AreaUnit::SQUARE_METRE);
$area2 = new Area(2, AreaUnit::SQUARE_KILOMETRE);

// Addition
$area = $area1->add($area2);

// Subtraction
$area = $area1->sub($area2);

// Multiplication
$area = $area1->mulByNumber(2);

// Division
$area = $area1->divByNumber(2);
$length = $area1->divByLength(new Length(10, LengthUnit::METRE));
$number = $area1->divByArea($area2);

// Comparison
$isEqual = $area1->isEqualTo($area2);
$isGreaterThan = $area1->isGreaterThan($area2, false);
$isLessThan = $area1->isLessThan($area2, false);

// Formatting
$format = $area1->format(AreaUnit:SQUARE_INCH, 2, Format::ACRONYM)
$format = $area1->format(AreaUnit:SQUARE_FOOT, 2, Format::SYMBOL)
$format = $area1->format(AreaUnit:SQUARE_METRE, 2, Format::Name)
```

### Volume

#### Volume Unit

The VolumeUnit class defines various units of volume, such as cube meter, cube kilometer, cube inch, cube foot, etc.

```
use Measurements\Volume\VolumeUnit;

$cubeMeter = new VolumeUnit(VolumeUnit::CUBE_METRE);
$cubeKilometer = new VolumeUnit(VolumeUnit::CUBE_KILOMETRE);
// ...
```

#### Volume Operations

The Volume class enables operations on volumes, such as addition, subtraction, multiplication, division, and comparison.
There is also a VolumeImmutable class which provides the same functionality, but never updates the internal values of an
instance.

```
use Measurements\Volume\Volume;
use Measurements\Volume\VolumeUnit;

// Create volume instances
$area1 = new Volume(100, VolumeUnit::CUBE_METRE);
$area2 = new Volume(2, VolumeUnit::CUBE_KILOMETRE);

// Addition
$volume = $volume1->add($volume2);

// Subtraction
$volume = $volume1->sub($volume2);

// Multiplication
$volume = $volume->mulByNumber(2);

// Division
$volume = $volume->divByNumber(2);
$length = $volume->divByLength(new Length(10, LengthUnit::METRE));
$number = $volume->divByArea($area);

// Comparison
$isEqual = $volume1->isEqualTo($volume2);
$isGreaterThan = $volume1->isGreaterThan($volume2, false);
$isLessThan = $volume1->isLessThan($volume2, false);

// Formatting
$format = $volume->format(VolumeUnit::CUBE_INCH, 2, Format::ACRONYM)
$format = $volume->format(VolumeUnit::CUBE_FOOT, 2, Format::SYMBOL)
$format = $volume->format(VolumeUnit::CUBE_METRE, 2, Format::Name)
```

## Contributing

Contributions are welcome! Please feel free to open issues or submit pull requests.

## License

This library is licensed under the MIT License. See the LICENSE file for details.

## Credits

This library is maintained by Cody Fulford.

For detailed information on classes, methods, and properties, please refer to the source code and documentation.
