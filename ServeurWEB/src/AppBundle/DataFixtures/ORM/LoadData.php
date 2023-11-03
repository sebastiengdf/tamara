<?php


namespace AppBundle\DataFixtures\ORM;

use CoreBundle\Entity\Config;
use AppBundle\Entity\Centrecout;
use AppBundle\Entity\Fournisseur;
use AppBundle\Entity\TVA;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadData implements FixtureInterface, ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        $configs = [
            ['name' => 'Admin Starter'],
        ];
        foreach ($configs as $config) {
            $configO = new Config();
            $configO->setName($config['name']);
            $manager->persist($configO);
        }
        $manager->flush();
        
        $centreCouts = [
            1 => ['code' => 'RE11100000', 'name' => 'RÉSEAU - FRAIS GX'],
			2 => ['code' => 'RE11100001', 'name' => 'DC - FRAIS GX'],
			3 => ['code' => 'RE11110LUB', 'name' => 'LUBS RES - FRAIS GX'],
			4 => ['code' => 'RE11121000', 'name' => 'COCO-CONSIG-FRAIS GX'],
			5 => ['code' => 'RE11131000', 'name' => 'CODO-CONSIG-FRAIS GX'],
			6 => ['code' => 'RE11132000', 'name' => 'CODO-REVEND-FRAIS GX'],
			7 => ['code' => 'RE11141000', 'name' => 'DODO-CONSIG-FRAIS GX'],
			8 => ['code' => 'RE11142000', 'name' => 'DODO-REVEND-FRAIS GX'],
			9 => ['code' => 'RE111CARTE', 'name' => 'RÉSEAU - CARTES'],
			10 => ['code' => 'RE111S0001', 'name' => 'ST ANDRÉ CAMBUSTON'],
			11 => ['code' => 'RE111S0002', 'name' => 'LE PORT RIV. GALETS'],
			12 => ['code' => 'RE111S0003', 'name' => 'ST PAUL CENTRE VILLE'],
			13 => ['code' => 'RE111S0004', 'name' => 'STANDRÉ CENTREVILLE'],
			14 => ['code' => 'RE111S0005', 'name' => 'ST JOSEPH'],
			15 => ['code' => 'RE111S0006', 'name' => 'STPIERRE CENTREVILLE'],
			16 => ['code' => 'RE111S0007', 'name' => 'ST GILLES LES HAUTS'],
			17 => ['code' => 'RE111S0008', 'name' => 'STPAUL PL. BOIS NÉF'],
			18 => ['code' => 'RE111S0009', 'name' => 'STLOUIS CENTREVILLE'],
			19 => ['code' => 'RE111S0010', 'name' => 'RAVINE DES CABRIS'],
			20 => ['code' => 'RE111S0011', 'name' => 'STE SUZANNE'],
			21 => ['code' => 'RE111S0012', 'name' => 'ST DENIS PROVIDENCE'],
			22 => ['code' => 'RE111S0013', 'name' => 'RIVIÈRE SAINT LOUIS'],
			23 => ['code' => 'RE111S0014', 'name' => 'ST DENIS LACAUSSADE'],
			24 => ['code' => 'RE111S0015', 'name' => 'ST PHILIPPE'],
			25 => ['code' => 'RE111S0016', 'name' => 'ST DENIS CAMÉLIAS'],
			26 => ['code' => 'RE111S0017', 'name' => 'ST LEU'],
			27 => ['code' => 'RE111S0018', 'name' => 'LE PORT ZUP'],
			28 => ['code' => 'RE111S0019', 'name' => 'STBENOIT CENTREVILLE'],
			29 => ['code' => 'RE111S0020', 'name' => 'STE CLOTILDE MOUFIA'],
			30 => ['code' => 'RE111S0021', 'name' => 'STECLOTILDE CLINIQUE'],
			31 => ['code' => 'RE111S0022', 'name' => 'STE CLOTILDE BUTOR 2'],
			32 => ['code' => 'RE111S0023', 'name' => 'ST GILLES THÉÂTRE'],
			33 => ['code' => 'RE111S0024', 'name' => 'LE PORT ZAC 2000'],
			34 => ['code' => 'RE111S0025', 'name' => 'STE MARIE LES CAFÉS'],
			35 => ['code' => 'RE111S0026', 'name' => 'ST PIERRE BANK'],
			36 => ['code' => 'RE111S0027', 'name' => 'ST PIERRE RN1'],
			37 => ['code' => 'RE111S0028', 'name' => 'TAMPON TROIS MARES'],
			38 => ['code' => 'RE111S0029', 'name' => 'STE CLOTILDE BUTOR I'],
			39 => ['code' => 'RE111S0030', 'name' => 'BRAS PANON'],
			40 => ['code' => 'RE111S0038', 'name' => 'ST JOSEPH SORTIE VIL'],
			41 => ['code' => 'RE111S0039', 'name' => 'STE SUZANNE-COCO'],
			42 => ['code' => 'RE111S0040', 'name' => 'STATION POIDS LOURDS'],
			43 => ['code' => 'RE111S0042', 'name' => 'TAMPON LA CHATOIRE'],
			44 => ['code' => 'RE111S0043', 'name' => 'BOIS D\'OLIVE'],
			45 => ['code' => 'RE111S2031', 'name' => 'STECLOTILDE RI.PLUIE'],
			46 => ['code' => 'RE111S2032', 'name' => 'TAMPON RIV. D\'ABORD'],
			47 => ['code' => 'RE111S2033', 'name' => 'STEMARIE GRDE MONTÉE'],
			48 => ['code' => 'RE111S2034', 'name' => 'LA SALINE LES HAUTS'],
			49 => ['code' => 'RE111S2035', 'name' => 'LA SALINE TAMARINS'],
			50 => ['code' => 'RE111S2036', 'name' => 'LA POSS MOULIN JOLI'],
			51 => ['code' => 'RE111S2037', 'name' => 'TAMPON ENTRÉE VILLE'],
			52 => ['code' => 'RE111S2041', 'name' => 'SAINT LOUIS LE GOL'],
			53 => ['code' => 'RE11200000', 'name' => 'COM.GAL-FRAIS GX'],
			54 => ['code' => 'RE11201000', 'name' => 'CG -HORS MINES OH'],
			55 => ['code' => 'RE11202000', 'name' => 'CG -MINES OH'],
			56 => ['code' => 'RE11211099', 'name' => 'CONSOMMAT-VTES GLOB'],
			57 => ['code' => 'RE11212099', 'name' => 'INDUSTRIE-VTES GLOB'],
			58 => ['code' => 'RE11213099', 'name' => 'TRANSPORT-VTES GLOB'],
			59 => ['code' => 'RE11215099', 'name' => 'AUTRES-VTES GLOB'],
			60 => ['code' => 'RE11217099', 'name' => 'ADMINISTRA-VTES GLOB'],
			61 => ['code' => 'RE11221099', 'name' => 'REVENDEURS-VTES GLOB'],
			62 => ['code' => 'RE11229099', 'name' => 'VOIL&PÊCHE-VTES GLOB'],
			63 => ['code' => 'RE11300000', 'name' => 'LUBRIFIANTS-FRAIS GX'],
			64 => ['code' => 'RE11310099', 'name' => 'LUB AUTO-VTES GLOB'],
			65 => ['code' => 'RE11320099', 'name' => 'LUB INDUS-VTES GLOB'],
			66 => ['code' => 'RE11340099', 'name' => 'LUB MARINE-VTES GLOB'],
			67 => ['code' => 'RE11350099', 'name' => 'LUB AUTRES-VTES GLOB'],
			68 => ['code' => 'RE11400000', 'name' => 'GPL - FRAIS GX'],
			69 => ['code' => 'RE11410000', 'name' => 'GPL COND -FRAIS GX'],
			70 => ['code' => 'RE11411099', 'name' => 'GPL COND -VTES GLOB'],
			71 => ['code' => 'RE11420000', 'name' => 'GPL VRAC-FRAIS GX'],
			72 => ['code' => 'RE11421099', 'name' => 'GPL VRAC-VTES GLOB'],
			73 => ['code' => 'RE11500000', 'name' => 'AVIATION - FRAIS GX'],
			74 => ['code' => 'RE11510000', 'name' => 'AVIA INTER-FRAIS GX'],
			75 => ['code' => 'RE11511099', 'name' => 'AVIA INTER-VTES GLOB'],
			76 => ['code' => 'RE11512000', 'name' => 'ATI'],
			77 => ['code' => 'RE11512001', 'name' => 'AIR AUSTRAL'],
			78 => ['code' => 'RE11512002', 'name' => 'CORSAIR'],
			79 => ['code' => 'RE11512003', 'name' => 'AIR MADAGASCAR'],
			80 => ['code' => 'RE11512099', 'name' => 'AVIA INT ATI-VTES GL'],
			81 => ['code' => 'RE11520000', 'name' => 'AVIA.LOCALE-FRAIS GX'],
			82 => ['code' => 'RE11521099', 'name' => 'AVIA LOCALE-VTES GLO'],
			83 => ['code' => 'RE11530000', 'name' => 'AVIA SPÉC-FRAIS GX'],
			84 => ['code' => 'RE11531099', 'name' => 'AVIA SPÉC-VTES GLOB'],
			85 => ['code' => 'RE11532099', 'name' => 'AVIA SPÉC-ARMÉE'],
			86 => ['code' => 'RE11600000', 'name' => 'FLUID SPÉC-FRAIX GX'],
			87 => ['code' => 'RE11610099', 'name' => 'FLD SPÉC-VTESNAT GLO'],
			88 => ['code' => 'RE11640099', 'name' => 'FLD SP-VTESNAT-CLTDO'],
			89 => ['code' => 'RE11650099', 'name' => 'FLD SP-VTES NAT-D/R'],
			90 => ['code' => 'RE11700000', 'name' => 'SOUTES - FRAIS GX'],
			91 => ['code' => 'RE11741099', 'name' => 'SOUTES-VTES DIR GLOB'],
			92 => ['code' => 'RE11800000', 'name' => 'BITUME-FRAIS GX'],
			93 => ['code' => 'RE11811099', 'name' => 'BITUME-INDUS-VTES GL'],
			94 => ['code' => 'RE11900000', 'name' => 'COMB LOURD-FRAIS GX'],
			95 => ['code' => 'RE11911099', 'name' => 'COMB LOURD-IND-VTGLO'],
			96 => ['code' => 'RE12000000', 'name' => 'VENTES MASS-FRAIS GX'],
			97 => ['code' => 'RE12011099', 'name' => 'VENTES MAS-VTES GLOB'],
			98 => ['code' => 'RE19100000', 'name' => 'LOGISTIQUE-FRAIS GX'],
			99 => ['code' => 'RE1910E747', 'name' => 'DÉPÔT CARBSRPP'],
			100 => ['code' => 'RE1910E748', 'name' => 'DÉPÔT AVIATION'],
			101 => ['code' => 'RE1910E749', 'name' => 'DÉPÔT PROD NOIRS SRE'],
			102 => ['code' => 'RE1910H494', 'name' => 'DÉPÔT LUB SIÈGE'],
			103 => ['code' => 'RE1910H529', 'name' => 'DÉPSOUS TRAITANT LUB'],
			104 => ['code' => 'RE1910H552', 'name' => 'DÉPÔT ADBLUEZAC 2000'],
			105 => ['code' => 'RE1910HQB1', 'name' => 'BIENS & SERV. SIÈGE'],
			106 => ['code' => 'RE1910L192', 'name' => 'DÉPÔT GPL SRPP'],
			107 => ['code' => 'RE1910L196', 'name' => 'DÉPÔT GPL ZAC 2000'],
			108 => ['code' => 'RE1910N153', 'name' => 'DÉPÔT CAMION GPL'],
			109 => ['code' => 'RE1910S691', 'name' => 'DÉPÔT STATION PL'],
			110 => ['code' => 'RE1910T045', 'name' => 'DÉPÔT TRANSIT GPL'],
			111 => ['code' => 'RE1910T046', 'name' => 'DÉPÔT TRANSIT CARB'],
			112 => ['code' => 'RE1910T047', 'name' => 'DÉPÔT TRANSIT LUB'],
			113 => ['code' => 'RE1910Z377', 'name' => 'DÉP ECHGE CONFR.SRPP'],
			114 => ['code' => 'RE1910Z388', 'name' => 'DÉP ECHGE CONF.LIBYA'],
			115 => ['code' => 'RE1910Z389', 'name' => 'DÉP ECHGE CONF.ENGEN'],
			116 => ['code' => 'RE19110001', 'name' => 'CAMIONS PB'],
			117 => ['code' => 'RE19110002', 'name' => 'CAMION GPL'],
			118 => ['code' => 'RE19110003', 'name' => 'RESPONS. LOGISTIQUE'],
			119 => ['code' => 'RE19110004', 'name' => 'ASSISTANT LOGISTIQUE'],
			120 => ['code' => 'RE19801001', 'name' => 'DG-FRAIS GX'],
			121 => ['code' => 'RE19801002', 'name' => 'SECRETARIAT DG'],
			122 => ['code' => 'RE19801003', 'name' => 'HSEQ'],
			123 => ['code' => 'RE19801004', 'name' => 'AUDIT - CONTRÔLE INT'],
			124 => ['code' => 'RE19801005', 'name' => 'COMMUNICATION'],
			125 => ['code' => 'RE19802001', 'name' => 'DAF-FRAIS GX'],
			126 => ['code' => 'RE19802002', 'name' => 'ADMIN DES VENTES'],
			127 => ['code' => 'RE19802003', 'name' => 'ACHATS'],
			128 => ['code' => 'RE19802004', 'name' => 'ADMIN DU PERSONNEL'],
			129 => ['code' => 'RE19802005', 'name' => 'COMPTA GÉNÉ/FISCA'],
			130 => ['code' => 'RE19802006', 'name' => 'TRESORERIE'],
			131 => ['code' => 'RE19802007', 'name' => 'CONTROLE DE GESTION'],
			132 => ['code' => 'RE19802008', 'name' => 'INFORMATIQUE ET TEL'],
			133 => ['code' => 'RE19802009', 'name' => 'JURIDIQUE'],
			134 => ['code' => 'RE19803001', 'name' => 'DC-FRAIS GX'],
			135 => ['code' => 'RE19803002', 'name' => 'SECRETARIAT DC'],
			136 => ['code' => 'RE19803003', 'name' => 'MONETIQUE'],
			137 => ['code' => 'RE19803004', 'name' => 'RESEAU'],
			138 => ['code' => 'RE19803005', 'name' => 'HORS RESEAU'],
			139 => ['code' => 'RE19803006', 'name' => 'MARKETING'],
			140 => ['code' => 'RE19804001', 'name' => 'DEX-FRAIS GX'],
			141 => ['code' => 'RE19804002', 'name' => 'SECRETARIAT DEX'],
			142 => ['code' => 'RE19804003', 'name' => 'MAINTENANCE'],
			143 => ['code' => 'RE19804004', 'name' => 'TRAVAUX & MAINTENANC'],	        
        ];
        foreach ($centreCouts as $centreCout) {
            $centreCoutO = new Centrecout();
            foreach ($centreCout as $key => $value) {
                $method = 'set'.ucfirst($key);
                $centreCoutO->$method($value);
            }
            $manager->persist($centreCoutO);
        }
        $manager->flush();
        
        
        $fournisseurs = [
                1 => ['code' => '70940', 'name' => 'ADECCO- SPRING', 'published' => 'false'],
        ];
        foreach ($fournisseurs as $fournisseur) {
            $fournisseurO = new $fournisseur();
            foreach ($fournisseur as $key => $value) {
                $method = 'set'.ucfirst($key);
                $fournisseurO->$method($value);
            }
            $manager->persist($fournisseurO);
        }
        $manager->flush();
        
        
        $tvas = [
             1 => ['code' => 'A0', 'name' => 'Pas de TVA collectee'],
			 2 => ['code' => 'A1', 'name' => 'TVA collectée 20%'],
			 3 => ['code' => 'A2', 'name' => 'TVA collectée 8,5%'],
			 4 => ['code' => 'A3', 'name' => 'TVA collectée 2,1%'],
			 5 => ['code' => 'C0', 'name' => 'TVA / immo. 8,5% déd au prorata'],
			 6 => ['code' => 'I0', 'name' => 'Pas de TVA deductible / immo.'],
			 7 => ['code' => 'I2', 'name' => 'TVA déductible / immo. 8,5%'],
			 8 => ['code' => 'I3', 'name' => 'TVA déduc. / immo. 2,1%'],
			 9 => ['code' => 'V0', 'name' => 'TVA déductible 0%'],
			 10 => ['code' => 'V2', 'name' => 'TVA deductible 20%'],
			 11 => ['code' => 'V3', 'name' => 'TVA déductible 8,5%'],
			 12 => ['code' => 'V5', 'name' => 'TVA déductible 2,1%'],
			 13 => ['code' => 'V8', 'name' => 'TVA 8,5 % déductible au prorata'],
			 14 => ['code' => 'V9', 'name' => 'TVA 2,1 % déductible au prorata'],
		];
        foreach ($tvas as $tva) {
            $tvaO = new TVA();
            foreach ($tva as $key => $value) {
                $method = 'set'.ucfirst($key);
                $tvaO->$method($value);
            }
            $manager->persist($tvaO);
        }
        $manager->flush();
    }
}