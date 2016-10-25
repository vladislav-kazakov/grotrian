<?php /* Smarty version 2.6.12, created on 2016-07-28 11:32:18
         compiled from view/en/articles/2.tpl */ ?>
			<div class="container_12 publication_2" >
            
            	<div  id="txt" class="grid_9">

<br/>
<h2 class="center_text"><b>SPECTROSCOPY OF ATOMS AND MOLECULES</b></h2>
<h1 class="center_text"><b>Computer Representation of Characteristics of Atomic Electron Shells</b></h1>
<h3 class="center_text"><b>V. G. Kazakov<sup><i>a</i></sup>, S. G. Rautian<i><sup>b</sup></i><sup>,<i>c</i></sup> and A. S. Yatsenko<i><sup>c</sup></i></b></h3>

<p><i><sup>a</sup>Novosibirsk State University, Novosibirsk, 630090 Russia<br/> <sup>b</sup> Lebedev Physical Institute, Russian Academy of Sciences, Moscow, 119991 Russia<br/> <sup>c</sup>Institute of Automation and Electrometry, Siberian Branch, Russian Academy of Sciences, Novosibirsk, 630090 Russia</i></p>
<p></p>
<p>Ever since their appearance, computational complexes have been used in the analysis of physical models [1]. In studies of complex objects, e.g., atomic electron shells, the potential of computing technique was also applied. For example, in [2], computer calculations of wave functions by the, Hartree-Fock method [3] were analyzed in detail. The authors of [4-6] used the program ATOM in calculations of wave functions, pho-toionization cross sections, and oscillator strengths, as well as of excitation and ionization cross sections by electron impact, in the Hartree-Fock approximation. In [7], an automated databank SPEKTR (spectrum) on atomic constants of ions was described, and evaluated data on spectral characteristics (energy levels) were presented. In [8], an automated calculation within the framework of the Hartree-Fock method with relativis-tic corrections using the Cowan programs was proposed.</p>
<p>Further development of information systems is connected with the tabular representation and storage of data on atomic constants (relational databases (RDBs) [9]). Ordering in coinciding parameters (positions of terms and transitions between terms) facilitates tree representation of data, which leads to compactness of RDBs and to expediting search. The advantage of computer RDBs compared to treeware (see, e.g., [10-14]) are the possibilities of keyword searches and searching for combinations of keywords, as well as the possibility of searching for different lines of elements lying in a specified spectral range.</p>
<p>Graphical representation of the electronic structure of atoms in the form of Grotrian diagrams is also important. A graphical construction is a two-dimensional problem whose main tools are line segments and numerical and alphabetic data. A computer version of a graphical construction makes it possible to</p>
<p>(i)&nbsp;yield complete information on the electronic-structure of an atom,</p>
<p>(ii)&nbsp;obtain a detailed spectral pattern by scaling up,</p>
<p>(iii)&nbsp;quickly find an object that is of interest from a particular viewpoint.</p>
<p>At present, there are many electronic information systems on spectral data [15]. Each developed country tends to have its own data resource. To have a general idea on the state of the art in this field, let us consider the most developed resources that contain experimental and theoretical data on the spectra of atoms and ions of different multiplicities of ionization.</p>
<p>The resource NIST Atomic Spectra Database (NIST ASD) [16] is maintained by the Atomic Spectroscopy Group from the Atomic Physics Division in the Physics Laboratory at the National Institute of Standards and Technology of the United States of America. The system contains experimental and theoretical data on the energy levels of 56 elements and on the transitions in 99 elements (atoms and ions of different multiplicity of ionization); altogether, there are more than 200000 entries. The information is presented in tabular and graphical forms, with all the levels and transitions contained being displayed.</p>
<p>The resource HASD (Handbook of Basic Atomic Spectroscopic Data) [17] is a handbook on atomic spectroscopy. It is also maintained by the Atomic Spectroscopy Group from the Atomic Physics Division in the Physics Laboratory at the National Institute of Standards and Technology of the United States of America. The resource contains partial data on the basic levels and transitions for 99 elements (atoms and ions). The information is presented in a tabular form.</p>
<p>The resource TIPTOPbase [ 18] is a part of the Opacity Project (OP) and IRON Project (IP), in which research groups from France, Germany, the United</p>
<p>Fig. 1. Schematic diagram of the ESA information system and of its operation in a three-level client-server architecture.</p>
<p>Kingdom, the United States, and Venezuela are involved. The system contains theoretical data on the levels and transitions for atoms and ions from isoelec-tronic sequences. The information is displayed in a tabular form; the graphical form is not provided for.</p>
<p>The resource AMODS (Atomic, Molecular and Optical Database Systems) [19] is maintained by the Laboratory of Quantum Optics at the Korea Atomic Energy Research Institute. The system contains experimental data on radiative transitions for 87 and on energy levels for 35 elements (atoms and ions of different multiplicity of ionization). The information is displayed in a tabular form; the graphical form is not provided for.</p>
<p>The resource The Atomic Line List [20] (version 2.04) is maintained by the Department of Physics and Astronomy at the University of Kentucky and by the Royal Observatory of Belgium. The system contains theoretical data on transitions in the range 0.5-10000 µm for atoms and ions of different multiplicity of ionization. There are about 930000 entries. The information is displayed in a tabular form; the graphical form is not provided for.</p>
<p>The resource Kurucz Atomic Line Database [21] is maintained by the Harvard Astrophysics Center and NASA (United States). The system contains experimental data on transitions in 79 elements (atoms and ions of different multiplicity of ionization). The information is displayed in a tabular form; the graphical form is not provided for.</p>
<p>The resource DAS (Data for Autoionizing States) [22] is a database on autoionizing states. This is the joint Korea-Japan Core University Program. The database contains tabular data on levels and transitions for 27 elements (atoms and ions).</p>
<p>The resource Spectr-W3 [23] is maintained by the International Science and Technology Center (Russia). The main developers are the Russian Federal Nuclear Center and the All-Russian Scientific Research Institute of Technical Physics. The system contains experimen-</p>
<p>tal data on energy levels and transitions of 94 elements (mainly for isoelectronic sequences). The information is displayed in a tabular form; the graphical form is not provided for.</p>
<p>The resource CAMDB (China Atomic and Molecular Database) [24] is maintained by the Institute of Applied Physics and Computational Mathematics of China. The system contains experimental data on energy levels and transitions of atoms, ions, and molecules. There are 850000 entries. The data were partially taken from the Spectr-W3 resource. The information is displayed in a tabular form; the graphical form is not provided for.</p>
<p>The resource CHIANITI [25] (version 5.1) was developed by researchers from the Naval Research Laboratory (USA), the Rutherford Appleton Laboratory (UK), the University College of London (UK), the Milliard Space Science Laboratory (UK), the University of Cambridge (UK), the George Mason University (USA), and Universita degli Studi di Firenze (Italy). The system contains experimental and theoretical data for ions with a high degree of ionization in the range 0.1-60000 µm. The information is displayed in a tabular form; the graphical form is not provided for.</p>
<p>The resource Electronic Structure of Atoms (ESA) [26] is developed by specialists from the Novosibirsk State University (NSU) and from the Institute of Automation and Electrometry, Siberian Branch, Russian Academy of Sciences and is maintained by the Russian Foundation for Basic Research. The system contains experimental and theoretical data on levels of 105 atoms and on transitions of 98 atoms. Altogether, there are 150000 entries. The information is displayed both in tabular and in graphical forms.</p>
<p>The electronic resource ESA is the information system that is founded on the database of spectra of atoms and ions. The system is organized on a three-level client-server architecture (Fig. 1), which is traditional for such systems. The essence of this architecture is a concerted operation of the three components of the soft-</p>
<p class="center_text">
<img src="/images/articles/img_4a.png" alt="" width="804" height="328"/><img src="/images/articles/img_4b.png" alt="" width="553" height="664"/>
</p>
<p>Fig. 2. Example of the Grotrian diagram for Al I (ESA NSU).</p>
<p>ware support—the client, the intermediate, and the server components.</p>
<p>The software at the client level is set directly on the user's PC and is responsible for submitting information in the form of documents. As software at the client level, only the standard freeware programs are used, such as web browser Internet Explorer and Adobe SVG Viewer (browser plug-in for viewing SVG images within webpages).</p>
<p>The software at the server and intermediate levels is set on the server of the information system. The software at the server level is the database management system (DBMS), which is responsible for storing numerical information on levels and spectra of atomic systems and submitting it on query. In the ESA information system, the MS SQL DBMS is used as the software at the server level.</p>
<p>Finally, the software at the intermediate level is responsible for preparing documents from numerical</p>
<p>data on user query and for their subsequent transmitting to the client software. In the ESA information system, the intermediate level is represented by the jointly operating server of applications, which is responsible for creating documents and that was developed by the collective of the project and the standard web Internet information server, which submits the documents created to users.</p>
<p>Documents with tabular data are formed on user queries, which involve several parameters and admit interactive sorting and filtering. Graphical documents are visualizations of spectral data for atoms in the form of Grotrian diagrams. There are two fundamental differences between graphical documents of the ESA information system and sparse analogs. First, algorithms for efficient selection of lines for their arrangement are realized, so that Grotrian diagrams obtained reflect well the basic structure of the atomic spectrum and combine good readability with high information</p>
<p>COMPUTER REPRESENTATION OF CHARACTERISTICS</p>
<p class="center_text">
<img src="/images/articles/img_4c.png" alt="" width="553" height="430"/>
</p>
<p>Fig. 3. Example of the Grotrian diagram for Al I (ASD <b>NIST</b>).</p>
<p>density. In some other systems, including NIST ASD, lines are not selected, which leads to a complete loss of readability of diagrams. Second, in the ESA information system, diagrams are drawn in the vector format, which (in contrast to the raster graphics used in other systems) not only yields a high image quality on any monitor screen, but is also suitable for hardcopy printing.</p>
<p>Figure 2 presents the Grotrian diagram for the Al I atom that was automatically constructed from the ESA database. The top row of the figure shows all known electron configurations, the second row presents atomic cores, and the third row shows the terms belonging to them. Such a scheme of construction of the atomic electron structure was proposed in [27]. Both Rydberg and autoionization states are shown.</p>
<p>Figure 3 shows the Grotrian diagram for the same atom proposed by the ASD NIST.</p>
<p>For more complex atoms with a large number of levels, the information system draws a contracted diagram to arrange it on the monitor screen.</p>
<p>The following contraction is performed:</p>
<p>(i) as a result of an identical multiplicity of terms of the same configuration (for example, the terms <sup>2</sup><i>S, </i><sup>2</sup><i>D, </i><sup>2</sup><i>G</i>, etc. are transformed into <sup>2</sup>(...);</p>
<p>(ii) with respect to the momentum <i>j </i>(for example, the terms <i>P&deg;<sub>1/2</sub></i>,<i> <sup>4</sup>P&deg;<sub>3/2</sub></i> and <i><sup>4</sup>P&deg;<sub>5/2</sub> </i>are transformed into <i><sup>4</sup>P&deg;<sub>1/2-5/2 </sub></i>).</p>
<p>Comparative characteristics of ASD NIST and ESA NSU</p>
<table frame="box" rules="all" border="1">
<tr>
<td>
<p>Parameters</p>
</td>
<td>
<p>ASD NIST</p>
</td>
<td>
<p>ESA NSU</p>
</td>
</tr>
<tr>
<td>
<p>Parameters of levels</p>
</td>
<td>
<p>Electron configuration, energy levels</p>
</td>
<td>
<p>Electron configuration, energy levels, lifetimes</p>
</td>
</tr>
<tr>
<td>
<p>Parameters of transitions</p>
</td>
<td>
<p>Energies of upper and lower levels, wavelength, oscillator strength, intensity, transition probability</p>
</td>
<td>
<p>Energies of upper and lower levels, wavelength, oscillator strength, intensity, transition probability, excitation cross section</p>
</td>
</tr>
<tr>
<td>
<p>Functionality</p>
</td>
<td>
<p>Parameter search, sorting results</p>
</td>
<td>
<p>Parameter search, sorting results</p>
</td>
</tr>
<tr>
<td>
<p>Information on levels in neutral atoms</p>
</td>
<td>
<p>57 elements (version 3.1)</p>
</td>
<td>
<p>105 elements</p>
</td>
</tr>
<tr>
<td>
<p>Information on transitions in neutral atoms</p>
</td>
<td>
<p>34 elements are classified; 65 elements are not classified</p>
</td>
<td>
<p>98 elements are classified</p>
</td>
</tr>
</table>
<p class="center_text">
<img src="/images/articles/img_4d.png" alt="" width="567" height="652"/>
</p>
<p>Fig. 4. Example of the Grotrian diagram for Nd I (ESA NSU, maximal contraction).</p>
<p>As an example, Fig. 4 shows the contracted diagram for the Nd I atom, whose database contains 710 levels and 200 transitions.</p>
<p>The brief analysis presented shows that only two information systems in the world—ASD NIST and ESA—are capable of constructing graphical representations in the form of Grotrian diagrams. Let us compare them in more detail (see table).</p>
<p>As is seen from this table, the ESA NSU information system is highly competitive with the best known ASD NIST information system.</p>
<p>Therefore, researchers use various programs that are aimed at perfecting, storing, and processing collected data on atomic spectra. The state of the art in computer science makes it possible to create and maintain databases on spectroscopic information. An advantage of electronic databases compared to treeware is the possibility of keyword search and of search for combinations of keywords, as well as the possibility of search for different lines of elements lying in specified spectral</p>
<p>ranges. The possibility of worldwide access via the Internet makes such information systems available to many researchers in various fields of science and engineering, as well as to students at universities and colleges.</p>
<p>We are grateful to A.M.Shalagin and D.A. Shapiro for fruitful discussions. This study was supported by the Russian Foundation for Basic Research, project no. 05-07-90220.</p>
<p>REFERENCES</p>
<p>1.&nbsp;C. Jablon and J. C. Simon, <i>Applications des modeles numeriques en physique </i>(Birkhauser Verlag, Basel, 1978; Nauka, Moscow, 1983).</p>
<p>2.&nbsp;F. Fisher, <i>The Hartree-Fock Metod for Atoms </i>(Wiley-Interscience, New York, 1977).</p>
<p>3.&nbsp;D. R. Hartree, <i>The Calculation of Atomic Structures </i>(Wiley, New York, 1957; Atomizdat, Moscow, 1960).</p>
<p>COMPUTER REPRESENTATION OF CHARACTERISTICS</p>
<p>4.&nbsp;M. Ya. Amus'ya and L. V. Chernysheva, <i>Automated System for Investigating Atomic Structures </i>(Nauka, Leningrad, 1983) [in Russian].</p>
<p>5.&nbsp;L. A. Valnshtein and U. I. Safronova, Preprint no. 2</p>
<p>(ISAN, Troitsk, 1985).</p>
<p>6.&nbsp;L. A. Valnshtein and V. P. Shevel'ko, Preprint no. 19 (FIAN, Moscow, 1983).</p>
<p>7.&nbsp;V. P. Bugaev, V. G. Pal'chikov, I. Yu. Skobelev, and A. Ya. Faenov, in <i>Spectral Methods and Instrumentation for Measuring the Plasma Parameters of Multiple Charged Ions </i>(NPO VNIIFTRI, Moscow, 1988), pp. 4-19 [in Russian].</p>
<p>8.&nbsp;R. Cowan, <i>The Theory of Atomic Structure and Spectra </i>(California Univ. Press, Berkely, 1981).</p>
<p>9.&nbsp;E. E. Gasanov and V. G. Kudryavtsev, <i>Information Storage and Search Theory </i>(Fizmatlit, Moscow, 2002) [in Russian].</p>
<p>10.&nbsp;Ch. Moore, <i>Atomic Energy Levels </i>(NSRDS-NBS, Washington, 1971), Vols. 1-3.</p>
<p>11.&nbsp;W. C. Martin, R. Zalubas, and L. Hagan, <i>Atomic Energy Levels; the Rare-Earth Elements </i>(NIST-NBS, Washington, 1978).</p>
<p>12.&nbsp;S. Baskin and J. Stoner, <i>Atomic Energy Levels and Grotrian Diagrams </i>(Willey, New York, 1975).</p>
<p>13.&nbsp;N. A. Odintsova and A. R. Striganov, <i>TRANSL </i>(Nauka, Moscow, 1982) [in Russian].</p>
<p>14.&nbsp;Ch. Korliss and U. Bozman, <i>Tables of Spectral Lines of Neutral and Ionized Atoms </i>(Mir, Moscow, 1968) [in Russian].</p>
<p>15.&nbsp;<a target="blank" href="http://plasma-gate.Weizmann.ac.il/dbfApp.html">http://plasma-gate.Weizmann.ac.il/dbfApp.html</a>.</p>
<p>16.&nbsp;<a target="blank" href="http://physics.nist.gov/PhysRefData/ASD/index.html">http://physics.nist.gov/PhysRefData/ASD/index.html</a>.</p>
<p>17.&nbsp;<a target="blank" href="http://physics.nist.gov/PhysRetData/Handbook/index">http://physics.nist.gov/PhysRetData/Handbook/index</a>.html.</p>
<p>18.&nbsp;<a target="blank" href="http://vizier.u-sti-asbg.fi/topbase/home.html">http://vizier.u-sti-asbg.fi/topbase/home.html</a>.</p>
<p>19.&nbsp;<a target="blank" href="http://adoms.kaeri.re.kr/">http://adoms.kaeri.re.kr/</a>.</p>
<p>20.&nbsp;<a target="blank" href="http://www.pa.uky.edn/@~petei7atomic">http://www.pa.uky.edn/@~petei7atomic</a>.</p>
<p>21.&nbsp;<a target="blank" href="http://www.cfa.harvard.edu/amp/ampdata/kurucz23/sekur">http://www.cfa.harvard.edu/amp/ampdata/kurucz23/sekur</a>.html.</p>
<p>22.&nbsp;<a target="blank" href="http://wwwsolar.nrl.navy.mil/chianti_linelist.html">http://wwwsolar.nrl.navy.mil/chianti_linelist.html</a>.</p>
<p>23.&nbsp;<a target="blank" href="http://spectr-w3.cnz.ru/">http://spectr-w3.cnz.ru/</a>.</p>
<p>24.&nbsp;<a target="blank" href="http://www.camdb.ac.en/e/">http://www.camdb.ac.en/e/</a>.</p>
<p>25.&nbsp;<a target="blank" href="http://www.colar.nrl.navy.mil/chianti.html">http://www.colar.nrl.navy.mil/chianti.html</a>.</p>
<p>26.&nbsp;<a href="http://asd.nsu.ru">http://asd.nsu.ru</a>.</p>
<p>27.&nbsp;A. S. Yatsenko, <i>Grotrian Diagrams of Neutral Atoms </i>(Nauka, Novosibirsk, 1993) [in Russian].</p>
<p><i>Translated by V. Rogovof</i></p>
</div>
			</div>
<!--End of content-->       

			<div class="clear"></div>
			<div id="empty"></div> 
		</div>
<!--End of wrapper-->    