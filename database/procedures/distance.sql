/**
 * Calculate the distance between two sets of coordinates.
 *
 */
DROP FUNCTION IF EXISTS distance;
CREATE FUNCTION distance (vacancy VARCHAR(15), user VARCHAR(15)) RETURNS FLOAT DETERMINISTIC
BEGIN

	SET @deg_lat1 = SUBSTRING_INDEX(vacancy, ',', 1);
	SET @deg_lng1 = SUBSTRING_INDEX(vacancy, ',', -1);
	SET @deg_lat2 = SUBSTRING_INDEX(user, ',', 1);
	SET @deg_lng2 = SUBSTRING_INDEX(user, ',', -1);

	SET @delta_lat = SIN(RADIANS(@deg_lat2 - @deg_lat1) / 2.0);
	SET @delta_lng = SIN(RADIANS(@deg_lng2 - @deg_lng1) / 2.0);

	SET @formula = @delta_lat * @delta_lat + @delta_lng * @delta_lng * COS(RADIANS(@deg_lat1)) * COS(RADIANS(@deg_lat2));

    RETURN 6371 * 2 * ATAN2(SQRT(@formula), SQRT(1 - @formula));

END