-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2022 at 08:38 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE `blogs` (
  `blogID` int(11) NOT NULL,
  `blogHeadline` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blogImagePath` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blogImageAlignment` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blogContent` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `blogDate` datetime NOT NULL DEFAULT current_timestamp(),
  `catID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blogID`, `blogHeadline`, `blogImagePath`, `blogImageAlignment`, `blogContent`, `blogDate`, `catID`, `userID`) VALUES
(2, 'Just Like A Woman', NULL, '', 'Nobody feels any pain\r\nTonight as I stand inside the rain\r\nEv&apos;rybody knows\r\nThat Baby&apos;s got new clothes\r\nBut lately I see her ribbons and her bows\r\nHave fallen from her curls\r\nShe takes just like a woman, yes she does\r\nShe makes love just like a woman, yes she does\r\nAnd she aches just like a woman\r\nBut she breaks just like a little girl.\r\nQueen Mary, she&apos;s my friend\r\nYes, I believe I&apos;ll go see her again\r\nNobody has to guess\r\nThat Baby can&apos;t be blessed\r\nTill she finally sees that she&apos;s like all the rest\r\nWith her fog, her amphetamine and her pearls\r\nShe takes just like a woman, yes she does\r\nShe makes love just like a woman, yes she does\r\nAnd she aches just like a woman\r\nBut she breaks just like a little girl.\r\nIt&apos;s was raining from the first\r\nAnd I was dying there of thirst\r\nSo I came in here\r\nAnd your long-time curse hurts\r\nBut what&apos;s worse\r\nIs this pain in here\r\nI can&apos;t stay in here\r\nAin&apos;t it clear that.\r\nI just can&apos;t fit\r\nYes, I believe it&apos;s time for us to quit\r\nWhen we meet again\r\nIntroduced as friends\r\nPlease don&apos;t let on that you knew me when\r\nI was hungry and it was your world\r\nAh, you fake just like a woman, yes you do\r\nYou make love just like a woman, yes you do\r\nThen you ache just like a woman\r\nBut you break just like a little girl.', '2022-04-12 00:00:00', 5, 2),
(3, 'Like a rolling Stone', NULL, '', 'Once upon a time you dressed so fine\r\nThrew the bums a dime in your prime, didn&apos;t you?\r\nPeople call say &apos;beware doll, you&apos;re bound to fall&apos;\r\nYou thought they were all kidding you\r\nYou used to laugh about\r\nEverybody that was hanging out\r\nNow you don&apos;t talk so loud\r\nNow you don&apos;t seem so proud\r\nAbout having to be scrounging your next meal\r\nHow does it feel, how does it feel?\r\nTo be without a home\r\nLike a complete unknown, like a rolling stone\r\nAhh you&apos;ve gone to the finest schools, alright Miss Lonely\r\nBut you know you only used to get juiced in it\r\nNobody&apos;s ever taught you how to live out on the street\r\nAnd now you&apos;re gonna have to get used to it\r\nYou say you never compromise\r\nWith the mystery tramp, but now you realize\r\nHe&apos;s not selling any alibis\r\nAs you stare into the vacuum of his eyes\r\nAnd say do you want to make a deal?\r\nHow does it feel, how does it feel?\r\nTo be on your own, with no direction home\r\nA complete unknown, like a rolling stone\r\nAh you never turned around to see the frowns\r\nOn the jugglers and the clowns when they all did tricks for you\r\nYou never understood that it ain&apos;t no good\r\nYou shouldn&apos;t let other people get your kicks for you\r\nYou used to ride on a chrome horse with your diplomat\r\nWho carried on his shoulder a Siamese cat\r\nAin&apos;t it hard when you discovered that\r\nHe really wasn&apos;t where it&apos;s at\r\nAfter he took from you everything he could steal\r\nHow does it feel, how does it feel?\r\nTo be on your own, with no direction home\r\nLike a complete unknown, like a rolling stone\r\nAhh princess on a steeple and all the pretty people\r\nThey&apos;re all drinking, thinking that they&apos;ve got it made\r\nExchanging all precious gifts\r\nBut you better take your diamond ring, you better pawn it babe\r\nYou used to be so amused\r\nAt Napoleon in rags and the language that he used\r\nGo to him he calls you, you can&apos;t refuse\r\nWhen you ain&apos;t got nothing, you got nothing to lose\r\nYou&apos;re invisible now, you&apos;ve got no secrets to conceal\r\nHow does it feel, ah how does it feel?\r\nTo be on your own, with no direction home\r\nLike a complete unknown, like a rolling stone', '2022-04-12 00:00:00', 5, 1),
(7, 'Mannish boy', NULL, '', 'Oh, yeah\r\nOh, yeah\r\nEverything gonna be alright this mornin&apos;\r\nNow, when I was a young boy\r\nAt the age of five\r\nMy mother said I was gonna be\r\nThe greatest man alive\r\nBut now I&apos;m a man\r\nI&apos;m age twenty-one\r\nI want you to believe me, honey\r\nWe having lots of fun\r\nI&apos;m a man (yeah)\r\nI spell M\r\nA, child\r\nN\r\nThat represent man\r\nNo B\r\nO, child\r\nY\r\nThat spell mannish boy\r\nI&apos;m a man\r\nI&apos;m a full-grown man\r\nI&apos;m a man\r\nI&apos;m a rollin&apos; stone\r\nI&apos;m a man\r\nI&apos;m a hoochie-coochie man\r\nSittin&apos; on the outside\r\nJust me and my mate\r\nI&apos;m made to move\r\nCome up two hours late\r\nWasn&apos;t that a man?\r\nI spell M\r\nA, child\r\nN\r\nThat represesnt man\r\nNo B\r\nO, child\r\nY\r\nThat spell mannish boy\r\nI&apos;m a man\r\nI&apos;m a full-grown man\r\nI&apos;m a man\r\nI&apos;m a rolllin&apos; stone\r\nI&apos;m a man\r\nFull-grown man\r\nOh, well\r\nOh, well', '2022-04-12 00:00:00', 6, 2),
(8, 'Louisiana Blues', NULL, '', 'I&apos;m goin&apos; down in Louisiana\r\nBaby, behind the sun\r\nI&apos;m goin&apos; down in Louisiana\r\nHoney, behind the sun\r\nWell, you know I just found out\r\nMy trouble just begun\r\nI&apos;m goin&apos; down in New Orleans, hmm\r\nGet me a mojo hand\r\nI&apos;m goin&apos; down in New Orleans\r\nGet me a mojo hand (oh take me with you, man, when you go)\r\nI&apos;m gon&apos; show all you good-lookin&apos; women\r\nJes&apos; how to treat your love\r\nLet&apos;s go back to New Orleans, boys', '2022-04-12 00:00:00', 6, 2),
(9, 'Hoochie Coochie', NULL, '', 'The gypsy woman told my mother\r\nBefore I was born\r\nI got a boy child&apos;s coming\r\nHe&apos;s gonna be a son of a gun\r\nHe gonna make pretty womens\r\nJump and shout\r\nThen the world wanna know\r\nWhat this all about\r\n&apos;Cause you know I&apos;m here\r\nEverybody knows I&apos;m here\r\nYeah, you know I&apos;m a hoochie coochie man\r\nEverybody knows I&apos;m here\r\nI got a black cat bone\r\nI got a mojo too\r\nI got the Johnny Concheroo\r\nI&apos;m gonna mess with you\r\nI&apos;m gonna make you girls\r\nLead me by my hand\r\nThen the world&apos;ll know\r\nThe hoochie coochie man\r\nBut you know I&apos;m here\r\nEverybody knows I&apos;m here\r\nYeah, you know I&apos;m a hoochie coochie man\r\nEverybody knows I&apos;m here\r\nOn the seventh hours\r\nOn the seventh day\r\nOn the seventh month\r\nThe seven doctors said\r\nHe was born for good luck\r\nAnd that you&apos;ll see\r\nI got seven hundred dollars\r\nDon&apos;t you mess with me\r\nBut you know I&apos;m here\r\nEverybody knows I&apos;m here\r\nYeah, you know I&apos;m a hoochie coochie man\r\nEverybody knows I&apos;m here', '2022-04-12 00:00:00', 6, 2),
(10, 'Heroes', NULL, '', 'I, I will be king\r\nAnd you, you will be queen\r\nThough nothing will drive them away\r\nWe can beat them, just for one day\r\nWe can be heroes, just for one day\r\nAnd you, you can be mean\r\nAnd I, I&apos;ll drink all the time\r\n&apos;Cause we&apos;re lovers, and that is a fact\r\nYes we&apos;re lovers, and that is that\r\nThough nothing will keep us together\r\nWe could steal time just for one day\r\nWe can be heroes for ever and ever\r\nWhat d&apos;you say?\r\nI, I wish you could swim\r\nLike the dolphins, like dolphins can swim\r\nThough nothing, nothing will keep us together\r\nWe can beat them, for ever and ever\r\nOh we can be Heroes, just for one day\r\nI, I will be king\r\nAnd you, you will be queen\r\nThough nothing will drive them away\r\nWe can be Heroes, just for one day\r\nWe can be us, just for one day\r\nI, I can remember (I remember)\r\nStanding, by the wall (by the wall)\r\nAnd the guns, shot above our heads (over our heads)\r\nAnd we kissed, as though nothing could fall (nothing could fall)\r\nAnd the shame, was on the other side\r\nOh we can beat them, for ever and ever\r\nThen we could be Heroes, just for one day\r\nWe can be Heroes\r\nWe can be Heroes\r\nWe can be Heroes\r\nJust for one day\r\nWe can be Heroes\r\nWe&apos;re nothing, and nothing will help us\r\nMaybe we&apos;re lying, then you better not stay\r\nBut we could be safer, just for one day\r\nOh-oh-oh-ohh, oh-oh-oh-ohh, just for one day', '2022-04-12 00:00:00', 7, 2),
(11, 'Blown ion the wind', NULL, '', 'How many roads must a man walk down\r\nBefore you call him a man?\r\nHow many seas must a white dove sail\r\nBefore she sleeps in the sand?\r\nYes, and how many times must the cannonballs fly\r\nBefore they&apos;re forever banned?\r\nThe answer, my friend, is blowin&apos; in the wind\r\nThe answer is blowin&apos; in the wind\r\nYes, and how many years must a mountain exist\r\nBefore it is washed to the sea?\r\nAnd how many years can some people exist\r\nBefore they&apos;re allowed to be free?\r\nYes, and how many times can a man turn his head\r\nAnd pretend that he just doesn&apos;t see?\r\nThe answer, my friend, is blowin&apos; in the wind\r\nThe answer is blowin&apos; in the wind\r\nYes, and how many times must a man look up\r\nBefore he can see the sky?\r\nAnd how many ears must one man have\r\nBefore he can hear people cry?\r\nYes, and how many deaths will it take &apos;til he knows\r\nThat too many people have died?\r\nThe answer, my friend, is blowin&apos; in the wind\r\nThe answer is blowin&apos; in the wind', '2022-04-12 00:00:00', 5, 1),
(25, 'All Along the Watchtower', './uploadedImages/1251999184_k1j-l9ym642czd87rhw0iaqoxg3tf_bsnevp5u_0867889001649783620.jpg', '', 'There must be some kind of way outta here\r\nSaid the joker to the thief\r\nThere&apos;s too much confusion\r\nI can&apos;t get no relief\r\nBusiness men, they drink my wine\r\nPlowmen dig my earth\r\nNone will level on the line\r\nNobody offered his word\r\nHey, hey\r\nNo reason to get excited\r\nThe thief, he kindly spoke\r\nThere are many here among us\r\nWho feel that life is but a joke\r\nBut, uh, but you and I, we&apos;ve been through that\r\nAnd this is not our fate\r\nSo let us stop talkin&apos; falsely now\r\nThe hour&apos;s getting late, hey\r\nHey\r\nAll along the watchtower\r\nPrinces kept the view\r\nWhile all the women came and went\r\nBarefoot servants, too\r\nWell, uh, outside in the cold distance\r\nA wildcat did growl\r\nTwo riders were approaching\r\nAnd the wind began to howl, hey\r\nAll along the watchtower\r\nAll along the watchtower', '2022-04-12 00:00:00', 5, 1),
(31, 'Rollin’ stone', './uploadedImages/735499585_sbrglp7n9y_2wx35h1-m80zkvuecftq4aojd6i_0562808001649833049.jpg', 'right', 'Well I wish I was a catfish\r\nSwimmin&apos; in a oh, deep blue sea\r\nI would have all you good lookin&apos; women\r\nFishin&apos;, fishin&apos; after me\r\n\r\nSure &apos;nough, after me\r\nSure &apos;nough, after me\r\n\r\nOh &apos;nough\r\nOh &apos;nough\r\nSure &apos;nough\r\n\r\nI went to my baby&apos;s house\r\nAnd I sit down oh, on her steps\r\nShe said, &quot;Come on in now, Muddy\r\nYou know my husband just now left\r\n\r\nSure &apos;nough, he just now left\r\nSure &apos;nough, he just now left\r\nSure &apos;nough\r\n\r\nOh well\r\nOh well&quot;\r\n\r\nWell, my mother told my father\r\nJust before hmm, I was born\r\n&quot;I got a boy child&apos;s comin&apos;, he&apos;s gonna be\r\nHe&apos;s gonna be a &quot;Rollin&apos; Stone&quot;\r\n\r\nSure &apos;nough, he&apos;s a &quot;Rollin&apos; Stone&quot;\r\nSure &apos;nough, he&apos;s a &quot;Rollin&apos; Stone&quot;\r\n\r\nOh well he&apos;s a\r\nOh well he&apos;s a\r\nOh well he&apos;s a&quot;\r\n\r\nWell, I feel, yes I feel\r\nFeel that I could lay down oh, time ain&apos;t long\r\nI&apos;ma catch the first thing smokin&apos;, back\r\n\r\nBack down the road I&apos;m goin&apos;\r\nBack down the road I&apos;m goin&apos;\r\nBack down the road I&apos;m goin&apos;\r\n\r\nSure &apos;nough back\r\nSure &apos;nough back', '2022-04-13 00:00:00', 6, 1),
(35, 'Sympathy for the devil', './uploadedImages/638894277_2px985brktyozwl_ucifmej1nva40dh763gsq-_0565380001649841007.jpg', 'right', 'Please allow me to introduce myself\r\nI&apos;m a man of wealth and taste\r\nI&apos;ve been around for a long, long years\r\nStole million man&apos;s soul an faith\r\nAnd I was &apos;round when Jesus Christ\r\nHad his moment of doubt and pain\r\nMade damn sure that Pilate\r\nWashed his hands and sealed his fate\r\nPleased to meet you\r\nHope you guess my name\r\nBut what&apos;s puzzling you\r\nIs the nature of my game\r\nStuck around St. Petersburg\r\nWhen I saw it was a time for a change\r\nKilled Tsar and his ministers\r\nAnastasia screamed in vain\r\nI rode a tank\r\nHeld a general&apos;s rank\r\nWhen the blitzkrieg raged\r\nAnd the bodies stank\r\nPleased to meet you\r\nHope you guess my name, oh yeah\r\nAh, what&apos;s puzzling you\r\nIs the nature of my game, oh yeah\r\nI watched with glee\r\nWhile your kings and queens\r\nFought for ten decades\r\nFor the gods they made\r\nI shouted out\r\nWho killed the Kennedys?\r\nWhen after all\r\nIt was you and me\r\nLet me please introduce myself\r\nI&apos;m a man of wealth and taste\r\nAnd I laid traps for troubadours\r\nWho get killed before they reached Bombay\r\nPleased to meet you\r\nHope you guessed my name, oh yeah\r\nBut what&apos;s puzzling you\r\nIs the nature of my game, oh yeah, get down, baby\r\nPleased to meet you\r\nHope you guessed my name, oh yeah\r\nBut what&apos;s confusing you\r\nIs just the nature of my game\r\nJust as every cop is a criminal\r\nAnd all the sinners saints\r\nAs heads is tails\r\nJust call me Lucifer\r\n&apos;Cause I&apos;m in need of some restraint\r\nSo if you meet me\r\nHave some courtesy\r\nHave some sympathy, and some taste\r\nUse all your well-learned politnesse\r\nOr I&apos;ll lay your soul to waste, mm yeah\r\nPleased to meet you\r\nHope you guessed my name, mm yeah\r\nBut what&apos;s puzzling you\r\nIs the nature of my game, mm mean it, get down\r\nWoo, who\r\nOh yeah, get on down\r\nOh yeah\r\nAah yeah\r\nTell me baby, what&apos;s my name?\r\nTell me honey, can ya guess my name?\r\nTell me baby, what&apos;s my name?\r\nI tell you one time, you&apos;re to blame\r\nWhat&apos;s my name\r\nTell me, baby, what&apos;s my name?\r\nTell me, sweetie, what&apos;s my name?', '2022-04-13 11:10:07', 8, 2),
(36, 'Angie', NULL, 'left', 'hhhhhhhh&lt;br&gt;\r\nhallo&lt;br&gt;', '2022-04-13 12:19:36', 8, 1),
(37, 'Jumping Jack Flash', './uploadedImages/1659814954_o0f43vix62adrl5phnjy1uems-gcb7t8kqz9w__0711105001649845436.jpg', 'left', 'I was born in a cross-fire hurricane&lt;br&gt;\r\nAnd I howled at my ma in the driving rain&lt;br&gt;\r\nBut it&apos;s all right now, in fact, it&apos;s a gas&lt;br&gt;\r\nBut it&apos;s all right. I&apos;m Jumpin&apos; Jack Flash&lt;br&gt;\r\nIt&apos;s a gas! Gas! Gas&lt;br&gt;\r\n&lt;br&gt;\r\nI was raised by a toothless, bearded hag&lt;br&gt;\r\nI was schooled with a strap right across my back&lt;br&gt;\r\nBut it&apos;s all right now, in fact, it&apos;s a gas&lt;br&gt;\r\nBut it&apos;s all right, I&apos;m Jumpin&apos; Jack Flash&lt;br&gt;\r\nIt&apos;s a gas! Gas! Gas&lt;br&gt;\r\n&lt;br&gt;\r\nI was drowned, I was washed up and left for dead\r\nI fell down to my feet and I saw they bled\r\nI frowned at the crumbs of a crust of bread\r\nYeah, yeah, yeah\r\nI was crowned with a spike right thru my head\r\nBut it&apos;s all right now, in fact, it&apos;s a gas\r\nBut it&apos;s all right, I&apos;m Jumpin&apos; Jack Flash\r\nIt&apos;s a gas! Gas! Gas\r\nJumping Jack Flash, it&apos;s a gas\r\nJumping Jack Flash, it&apos;s a gas\r\nJumping Jack Flash, it&apos;s a gas\r\nJumping Jack Flash, it&apos;s a gas\r\nJumping Jack Flash', '2022-04-13 12:23:56', 8, 1),
(38, 'Cherry oh baby', './uploadedImages/499263958_c3ewn29x6l7r4btsjhai1-fygpvukm85_oq0zd_0754091001649876537.jpg', 'left', 'Oh, Cherry, oh Cherry, oh baby\r\nDon&apos;t ya know I in need of thee\r\nYou don&apos;t believe it true\r\nWhy don&apos;t you love me, too\r\nIts so long I&apos;ve been waiting\r\nFor you to come right in\r\nNow that we are together\r\nIs make my joy run over\r\nYeah [Repeat: x7]\r\n{Chorus]\r\n\r\nOh Cherry, oh Cherry, oh baby\r\nDon&apos;t ya know I in love with you\r\nYou don&apos;t believe I know\r\nSo why don&apos;t you try me\r\nI&apos;m never gonna let you down\r\nNever make you wear no frown\r\nYou say you love me madly\r\nThen why do you treat me badly\r\nYeah [Repeat: x7]\r\n\r\nOh Cherry, oh Cherry, oh baby\r\nDon&apos;t ya know I in love with you\r\nYou don&apos;t believe I know\r\nSo why don&apos;t you try me (try me)\r\nI&apos;m never gonna let you down no\r\nNever make you wear no frown\r\nYou say you love me madly\r\nThen why do you treat me badly\r\nYeah [Repeat: x3]', '2022-04-13 21:02:17', 8, 2),
(39, 'Cali pachanguero', './uploadedImages/2103736694_9f3sy0ac_mh2bwvjlr74qg1xu5idez-kptno68_0116281001649877169.jpg', 'left', 'Cali pachanguero\r\nCali luz de un nuevo cielo\r\nCali pachanguero\r\nCali luz de un nuevo cielo\r\nDe romántica luna\r\nEl lucero que es lelo\r\nDe mirar en tu valle\r\nLa mujer que yo quiero\r\nY el jilguero que canta\r\nCalles que se levantan\r\nCarnaval en Juanchito\r\nTodo un pueblo que inspira\r\nCali pachanguero\r\nCali luz de un nuevo cielo\r\nCali pachanguero\r\nCali luz de un nuevo cielo\r\nEs por eso que espero\r\nQue los días que lejos\r\nCuando dure mi ausencia\r\nSabes bien que me muero\r\nTodos los caminos conducen a ti\r\nSi supieras la pena que un día sentí\r\nCuando en frente de mí tus montañas no vi\r\nQue todo, que todo, que todo, que todo, ¿qué?\r\nQue todo el mundo te cante\r\nQue todo el mundo te mime\r\nCeloso estoy pa&apos; que mires\r\nNo me voy más ni por miles\r\nPermita que me arrepienta, oh\r\nMi bella cenicienta\r\nDe rodillas mi presencia\r\nSi mi ausencia fue tu afrenta\r\nQue noches, que noches tan bonitas\r\nSi lo e&apos; en sus callecitas\r\nAl fondo mi valle en risa\r\n¡Ay!, todito se divisa\r\nUn clásico en el Pascual\r\nAdornado de mujeres sin par\r\nAmérica y Cali a ganar\r\nAquí no se puede empatar\r\nBarranquilla puerta de oro\r\nParís la ciudad luz\r\nNueva York capital del mundo\r\nDel Cielo Cali la sucursal\r\nA millas siento tu aroma\r\nCualquiera justo razona\r\nQue Cali es Cali señoras, señores\r\nLo demás es loma', '2022-04-13 21:12:49', 9, 2),
(40, 'Esto te pone la cabeza mala', './uploadedImages/1302786886_q9bn17p-cvzo0kgf45e6tmwul2ahy8sr_djix3_0967192001649917331.jpg', 'right', 'Vengo de Nigeria, Yoruba Arará y Carabalí\r\nNigeria y Congo son mi tierra\r\nMozambique y Angola soy de allí\r\nEh-eh, oh-oh\r\nVengo de Nigeria, Yoruba Arara&apos; y Carabalí\r\nNigeria y Congo son mi tierra\r\nMozambique y Angola soy de alí\r\nEh-eh, oh-oh, brr\r\nEsa música que heredamos\r\nHijos y nietos de los africanos\r\nLa que mezclamos con la española\r\nCon la francesa y la portuguesa\r\nLa que fundimos bien con la inglesa\r\nPor eso decimos que es una sola\r\nTimba con rumba y rock\r\nMambo con conga y pop\r\nSalsa con mozambique\r\nY clave de guaguanco\r\nCumbia y congas con swing\r\nSongo con samba y beat\r\nMerengue con bomba y son\r\nY clave de guaguanco\r\nAy, bombo, canilla y campana\r\nQue tumba guiro y hasta mañana\r\n(Bombo, canilla y campana)\r\n(Un buen guiro y hasta mañana)\r\nAy con este ritmo tan afincao\r\nBailen bien, que aquí el que baila gana\r\n(Bombo, canilla y campana)\r\n(Un buen guiro y hasta mañana)\r\nBombo layé, layé, ay, bombo layé\r\nPa&apos; que baile usted\r\n(Bombo, canilla y campana)\r\n(Un buen guiro y hasta mañana)\r\nSa-la-la-la-la-la-la-la-la-ah\r\nCampanero\r\n(Bombo, canilla y campana)\r\n(Un buen guiro y hasta mañana)\r\nAy, aquí sí sale o sino no sale\r\nLa cosa es de aprendizaje\r\nAhí na&apos;má, ahí na&apos;má\r\nBrr, ¿qué es esto? Ay, Dio&apos;\r\n\r\n(Esto te pone la cabeza mala)\r\nUna aspirina, me duele la cabeza\r\n(Esto te pone la cabeza mala)\r\nY, si no te preocupa, por qué te interesa, ¿mamá?\r\n(Esto te pone la cabeza mala)\r\nPero baila como Chen-Chen-Chen-Chen-Chen\r\n(Esto te pone la cabeza mala)\r\nY de las 7:00 hasta las 12:00, para que goce\r\n(Esto te pone la cabeza mala)\r\nYalambire, yalambire, yalambarara\r\n(Esto te pone la cabeza mala)\r\n¡Ahí!\r\n(Esto te pone la cabeza mala)\r\nMove it, move it, move it, move it, move it, move it, move it, move it\r\n(Esto te pone la cabeza mala)\r\n(Esto te pone la cabeza mala)\r\nY todo el mundo de pie\r\nY con las manos en la cabeza\r\n(Esto te pone la cabeza mala)\r\nAvisale a Cristina y también a Teresa, mamá\r\n(Esto te pone la cabeza mala)\r\nOye, ay, mamá, cómo vengo este año\r\n(Esto te pone la cabeza mala)\r\nAy, ¿cómo? Acabando y acabando\r\n(Esto te pone la cabeza mala)\r\nOye, y angolonao\r\n(Esto te pone la cabeza mala)\r\n¿Cómo es que te la pone a ti?\r\n¿Cómo es que te la pone a ti?\r\n¿Cómo es que te la pone a ti?\r\nAhí na&apos;má, voy ahí, ahí na&apos;má\r\n(Esto te pone la cabeza mala) Voy ahí\r\nAhí na&apos;má, voy ahí (¿Cómo?), ahí na&apos;má\r\n(Esto te pone la cabeza mala) Voy ahí, ¿cómo?\r\nY con las manos para arriba\r\n(Esto te pone la cabeza mala)\r\nY con las manos en la cabeza\r\nTi-ti-ti-ti-ti-ti-ti\r\nY ataca, Guayacán\r\n(Esto te pone la cabeza mala)\r\n(Esto te pone la cabeza mala)', '2022-04-14 08:22:11', 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `catID` int(11) NOT NULL,
  `catLabel` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catID`, `catLabel`) VALUES
(5, 'Dylan'),
(6, 'Muddy Waters'),
(7, 'Davis Bowie'),
(8, 'Rolling Stones'),
(9, 'Grupo Niche'),
(10, 'Los Van Van');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userFirstName` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userLastName` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userEmail` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userCity` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userPassword` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userFirstName`, `userLastName`, `userEmail`, `userCity`, `userPassword`) VALUES
(1, 'Donald', 'Duck', 'a@b.c', 'DuckCity', '$2y$10$AsbzwMgz8e4qoD9G1e.xse4evbcPRIsdUtZw5bfw2GIJuI6Fay.26'),
(2, 'Kwik', 'Duck', 'kwik@duck.com', 'DuckTown', '$2y$10$BS2qIQetVxh.XejaMSqG4upOG5KNJNfkZ5g2VcivYfi6.0v8ZuiY2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blogID`),
  ADD KEY `catID` (`catID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
