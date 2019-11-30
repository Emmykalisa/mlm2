<?php

require_once 'constants.php';
    class AmountCalculator
    {
        private $conn;
        private $leftPoints;
        private $rightPoints;

        public function __construct($leftPoints, $rightPoints)
        {
            require_once 'connect.php';
            global $con;
            $this->conn = $con;
            $this->leftPoints = $leftPoints;
            $this->rightPoints = $rightPoints;
        }

        public function getCount($side)
        {
            return 'left' == $side ? $this->leftPoints : $this->rightPoints;
        }

        public function matchUsers()
        {
            $match = 0;
            if ($this->leftPoints || $this->rightPoints) {
                include 'connect.php';
                $userident = $_SESSION['userident'];
                if ($this->leftPoints < $this->rightPoints) {
                    $match = $this->leftPoints;
               } elseif ($this->leftPoints > $this->rightPoints) {
                    $match = $this->rightPoints;
                      
                } elseif ($this->leftPoints == $this->rightPoints) {
                    $match = $this->leftPoints = $this->rightPoints;
                        
                }
            }

            return $match;
        }

        public function getIndirectProfit()
        {
            $leftIndirect = $this->indirectMarks($this->leftPoints);
            $rightIndirect = $this->indirectMarks($this->rightPoints);

            return $leftIndirect + $rightIndirect;
        }

        public function getGiftCheck()
        {
            $match = $this->matchUsers();

            return intdiv($match, 5);
        }

         public function Flashout()
        {
            $match = $this->matchUsers();

            return intdiv($match, 6);
        }
        
        public function getLRPoints()
        {
            $points = 0;
            if ($this->leftPoints && $this->rightPoints) {
                $points = 2;
            } elseif ($this->leftPoints || $this->rightPoints) {
                $points = 1;
            }

            return $points;
        }

        public function getTotalPoints()
        {
            $match = $this->matchUsers() * QUANTITY_BONUS;
            $firstPoints = $this->getLRPoints() * SIDE_BONUS;
            $indirect = $this->getIndirectProfit() * INDIRECT_BONUS;
            $profit = $this->getGiftCheck() * QUANTITY_BONUS;

            return $match + $indirect - $profit;
        }

        public function indirectMarks($marks)
        {
            $points = 0;
            if ($marks >= 4 && $marks < 16) {
                $points = 1;
            } elseif ($marks >= 16 && $marks < 64) {
                $points = 2;
            } elseif ($marks >= 64) {
                $points = 2;
            }

            return $points;
        }
    }

    // For testing the tree functionality, Uncomment these lines

    // $calculator = new AmountCalculator(6, 3);
    // echo '<br/>Left side: '.$calculator->getCount('left').'<br/>';
    // echo 'Right side: '.$calculator->getCount('right').'<br/>';
    // echo 'Your matching: '.$calculator->matchUsers().'<br/>';
    // echo 'Your indirect profit: '.$calculator->getIndirectProfit().'<br/>';
    // echo 'Your gift check: '.$calculator->getGiftCheck().'<br/>';
    // echo 'Total marks: '.$calculator->getTotalPoints();