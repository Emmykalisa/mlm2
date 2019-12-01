<?php

require_once 'constants.php';
    class AmountCalculator
    {
        private $conn;
        private $leftCount;
        private $rightCount;

        public function __construct($leftCount, $rightCount)
        {
            require_once 'connect.php';
            global $con;
            $this->conn = $con;
            $this->leftCount = $leftCount;
            $this->rightCount = $rightCount;

        }

        public function getCount($side)
        {
            return 'left' == $side ? $this->leftCount : $this->rightCount;
        }

        public function matchUsers()
        {
            $match = 0;
            if ($this->leftCount || $this->rightCount) {
               
                if ($this->leftCount < $this->rightCount) {
                    $match = $this->leftCount;
               } elseif ($this->leftCount > $this->rightCount) {
                    $match = $this->rightCount;
                      
                } elseif ($this->leftCount == $this->rightCount) {
                    $match = $this->leftCount = $this->rightCount;
                        
                }
            }

            return $match;
        }

        public function getIndirectProfit()
        {

             include"connect.php";
$userident = $_SESSION['userident'];
$select = $dbi->query("SELECT * FROM tree where userident='{$userident}' order by id desc limit 1");
while($rows=mysqli_fetch_array($select)){
     $rightview=$rows['matchedview'];

     $leftview=$rows['matchedview'];

   
}
            $leftIndirect = $this->indirectMarks($this->leftCount+$leftview);
            $rightIndirect = $this->indirectMarks($this->rightCount+$rightview);
            return $leftIndirect + $rightIndirect;
        }

        public function getGiftCheck()
        {

             include"connect.php";
$userident = $_SESSION['userident'];
$select = $dbi->query("SELECT * FROM tree where userident='{$userident}' order by id desc limit 1");
while($rows=mysqli_fetch_array($select)){
     $matchi=$rows['matchedview'];

     
   
}
            $matchu = $this->matchUsers();
            $match=$matchu+$matchi;

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
            if ($this->leftCount && $this->rightCount) {
                $points = 2;
            } elseif ($this->leftCount || $this->rightCount) {
                $points = 1;
            }

            return $points;
        }


        public function getTotalPoints()
        {

            include"connect.php";
$userident = $_SESSION['userident'];
$select = $dbi->query("SELECT * FROM tree where userident='{$userident}' order by id desc limit 1");
while($rows=mysqli_fetch_array($select)){
    $matchu=$rows['matches'];
     $matchi=$rows['matchedview'];

     $matcho=$matchu+$matchi;
   
}

                               
            $match = $matcho * QUANTITY_BONUS;
            $firstPoints = $this->getLRPoints() * SIDE_BONUS;
            $indirect = $this->getIndirectProfit() * INDIRECT_BONUS;
            $profit = $this->getGiftCheck() * QUANTITY_BONUS;

            return $match+ $indirect - $profit;
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