KMeans
======

Usage
---------------------------------

    $kmeans = new KMeans();
    var_dump($kmeans->cluster(
            array(
        array(1, 1),
        array(1, 2),
        array(2, 1),
        array(5, 5),
        array(5, 6),
        array(6, 5)
            )
            , 2, "Euclid"
            ));
