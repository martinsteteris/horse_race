<?php

$horses = explode(' ', readline("Enter horse names: "));
$trackDistance = 50;
$race = [];
$horsesFinished = [];
$playerWallet = 20;
$moveMin = 2;
$moveMax = 7;


while ($playerWallet > 0) {
    system('clear');
    $horsesFinished = [];

    echo "Choose your horse, player!" . PHP_EOL . implode(' / ', $horses) . PHP_EOL;
    $betHorse = readline('>');
    if (! in_array($betHorse, $horses)) {
        echo 'NO SUCH HORSE!' . PHP_EOL;
        sleep (1);
        continue;
    }
    $betAmount = readline('Enter bet: ');
    if ($betAmount > $playerWallet) {
        echo 'NOT ENOUGH PESO!' . PHP_EOL;
        sleep(1);
        continue;
    }

    for ($i = 0; $i < count($horses); $i++) {
        $race[$i] = array_fill(0, $trackDistance, '-');
        $race[$i][0] = $horses[$i];
    }
    system('clear');

    foreach ($race as $track) {
        echo implode('', $track);
        echo PHP_EOL;
    }
    sleep(1);

    while (count($horsesFinished) < count($horses)) {
        system("clear");

        for ($i = 0; $i < count($horses); $i++) {
            $currentPosition = array_search($horses[$i], $race[$i]);
            $move = rand($moveMin, $moveMax);
            $nextPosition = $currentPosition + $move;

            if ($horses[$i] >= $trackDistance - 1) {
                $race[$i][$trackDistance - 1] = $horses[$i];
            }
            if (!in_array($horses[$i], $horsesFinished)) {
                $race[$i][$currentPosition + $move] = $horses[$i];
                $race[$i][$currentPosition] = '-';
            }
            if ($nextPosition >= $trackDistance && !in_array($horses[$i], $horsesFinished)) {
                $horsesFinished[] = $horses[$i];
            }

        }
        foreach ($race as $track) {
            echo implode('', $track);
            echo PHP_EOL;
        }
        sleep(1);
    }
    echo "Race is over! Rankings are as follows:" . PHP_EOL;
    foreach ($horsesFinished as $place => $horse) {
        echo "#" . ($place + 1) . ": $horse" . PHP_EOL;
    }
    $reward = 0;
    for ($i = 0; $i < count($horses); $i++) {
        if ($betHorse == $horsesFinished[$i]) {
            $reward = max((count($horses) - $i * 2), 0) * $betAmount / 2;
            echo "Your reward: $reward" . PHP_EOL;
            $playerWallet = $playerWallet - $betAmount + $reward;
        }
    }
    echo "you have $playerWallet peso left." . PHP_EOL;
    $replay = readline('Want another race? y/n : ' );
    if ($replay == 'y') {
        continue;
    } else {
        exit;
    }
}
echo "Thanks for your money. Bye bye!";
