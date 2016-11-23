			<div class="container_12 publication_1" >
            
            	<div id="txt" class="grid_9">
<br/>
<h2 class="center_text"><b>INFORMATION SYSTEM &quot;ELECTRONIC STRUCTURE OF ATOMS&quot; WITH DYNAMIC CONSTRUCTION OF A GRAPHIC DISPLAY OF SPECTRAL DATA</b></h2>
<p class="center_text"><b>V.G.Kazakov, A.S.Tyumentsev, and A.S.Yatsenko</b><br/><i>Novosibirsk</i></p>
<p class="center_text"><b>INTRODUCTION</b></p>
<p>Gathering and analysis of information on the properties of some physical systems are an important part of scientific research. For instance, for gas or plasma systems this information frequently concerns parameters of atoms, molecules, and ions, that is, characteristics of energy levels and radiation transitions between them. The most traditional procedure for representing these data is the use of tables. For example, paper [1] presents tables containing information on energy levels of an atom or its ion, which were sorted in increasing energy. Paper [2] presents all allowed transitions between different levels.</p>
<p>Accurate and comprehensive data on optical spectra of atomic systems are conventionally presented as tables; and graphical representations are successfully used for general analysis of electronic structures of nuclei, atoms, or molecules.</p>
<p>Paper [3] describes the main stages of evolution of graphical representation of atomic systems in the form of diagrams in order to illustrate distribution of excited states in electronic configurations and mark the most intensive transitions. The Grotrian diagram looks like a rectangle with given sizes inside which the electronic structure of the atomic system is represented by lines, letters, and numbers. The energy levels are laid off on the ordinate and the designations of terms are plotted on the abscissa. Even and odd states alternate. The energy in terms of reciprocal centimeters (cm<sup>-1</sup>) and electron-volts (eV) is laid off on vertical scales. Slanting lines show radiation transitions.</p>
<p>The technique of constructing Grotrian diagrams somewhat changed and presently there are several kinds of them. For instance, diagrams [5, 6] that differ from Grotrian diagrams because they show forbidden transitions are applied in astrophysics. The problem of constructing diagrams for atoms with a great nuclear charge of Z (from H to Mn) was solved by authors of [7] who used several diagrams with different electronic configurations for describing a complete electronic structure of one element. One more solution of this problem became
application of an attendant table, along with the Grotrian diagram, which contains information on levels and transitions that did not go in the diagram. This approach was used in [8] that presents information on spectra of atoms and ions from Z = 26 (Fe) to Z = 42 (Mo).</p>
<p>Papers [9, 10] present diagrams for most of elements in the Periodic Table. They use a technique that differs from the foregoing ones [7, 8]. The first (top) line of the diagram contains a designation for all available electronic configurations <i>nl<sup>k</sup> </i>the second line presents terms of atomic cores, and the third line presents terms of energy states of atoms. Even and odd terms in the last line are spaced from the ground state to different sides of the diagram. Compared with diagrams from [7, 8], this diagram as well as the original Grotrian one is placed on one page, contains sufficient information, and is convenient for usage.</p>
<p>At present, one can find tabulated information and Grotrian diagrams (printed information) in the Internet Network. For instance, tables from [11] are presented in [12] as a text, whereas paper [13] presents diagrams from [6] as raster pictures. Some diagrams are also available in [14]. This copying allows constant actualization of information but this technique is not interactive and cannot ensure mechanisms for information sorting and detailing.</p>
<p>There are some systems with different functional options that provide necessary means for information retrieval and preprocessing to the user. For example, the ASDB Program works with tabulated data and allows sampling and sorting by parameters. A demoversion of this program is available in [15]. Information systems (IS) based on databases (DB) with publication in the Internet Network are most complicated in implementation although most attractive. These systems ensure obtaining partial information as tables or the whole database, and also interactive SQL inquiring [16]. At present, there are many such systems in the world, which allow information access over various protocols (http, ftp, or telnet), they are reviewed in [17]. One of the most complete DBs is ASD NIST USA; it contains information on radiation transitions of 99 elements and energy levels of 52 elements [12]. There are other systems with similar possibilities: NIFS, AMDIS, OPD, and COREX, their addresses are listed in [18].</p>
<p>The described systems satisfy completely researcher needs in tabulated information, nevertheless they cannot help to overcome the deficit of graphical representations because they cannot automatically construct Grotrian diagrams yet. Graphical representations available in the computer medium just copy diagrams of printed editions without extending their list or functionality. An effective method for solving this problem is dynamic construction of user diagrams by a computer system based on an extensive database. This method has not been implemented yet. We know the only attempt to construct a diagram by means of a special program &quot;Multi-Photon Grotrian Diagram&quot; is described in [15]. However, dynamic construction is absent here: transitions for mapping are chosen manually. Moreover, only a partial diagram can be constructed in the program.</p>
<p>Thus, an urgent problem is constructing IS on spectral data on atoms to ensure, besides data sampling, sorting, and tabulating functions, construction of Grotrian diagrams with the necessary degree of detailing. We will solve this problem in the present paper.</p>
<p><b>Automatic construction of Grotrian diagrams. </b>Until now a skilled specialist solved the problem of constructing a Grotrian diagram convenient for use. An important stage of creation is selection of levels and transitions that represent the properties of atoms best of all. Although such criteria as an intensity or wavelength are available for solving this problem, expert evaluation of the situation is of considerable importance. Another stage is layout of levels and translations on a diagram to ensure its best &quot;readability&quot;. With that, besides the formalized criteria, author's opinion is also present. The situation becomes complicated because it is frequent practice that search for solution at the second stage leads to revision of results of the first one. Automatic construction requires a rigorous algorithm to ensure adequate quality of obtained diagrams.</p>
<p>To construct the algorithm, we chose the approach from [9] in which even and odd atomic states are separated, hence, the information density will be increased. Resonance transitions from the ground state to excited states and subsequent intensive transitions are represented as follows. The energy levels and the transitions between them are presented as a graph (the levels are vertices, and the transitions are edges) [19]. A &quot;graph - tree&quot; (stem and branches) schematic was used. The stem is the ground state, and the parallel branches are possible transitions to excited states, which will decrease the lengths of segments and eliminate the crosses. According to [9, 10], the general view of the automatically constructed diagram is shown in Fig. 1. The first line presents electronic configurations of states, the second line - atomic cores, and the third line - all possible terms. Several</p>
<img src="/images/articles/img_3.png" alt=""/><p>terms correspond to each configuration. Energy levels are plotted on the ordinate, and designations of terms are laid off on the abscissa.</p>
<p>We will consider the algorithm for selection of mapped transitions for initial construction of the diagram. It is important to present in it the resonance lines (transitions from the ground state) and lines of transitions from excited states. At that, the wavelength of the mapped transition should be taken into account. At first, we should present transitions with the wavelength from the visible and near-IR regions as the most useful ones for researchers. Problems arise when these requirements come in conflict. It was visually found that while mapping simultaneously more than 30 transition lines, the diagram becomes intricate, but the number of lines satisfying the initial criteria can be more than 100. In complex elements, the problem of selecting the mapped transitions is also closely related with their probable overlapping.</p>
<p>We will describe the used level selection algorithm.</p>
<p>1.&nbsp;For drawing, select resonance lines from the ground state with the greatest wavelength (no more than 20 lines).</p>
<p>2.&nbsp;From the whole set of transitions, select those with the greatest wavelength and intensity. From the same transitions, gather additionally some lines to reach 30. On average, the number per graph vertex is approximately the same.</p>
<p>3.&nbsp;Check layout of the lines on the diagram. If some transition overlaps other elements of the diagram, this transition is temporarily eliminated from consideration and the next element is selected from the list (see Item 2).</p>
<p>The next task is to layout the information on the diagram in such a manner that to ensure readability. The problem concerned with overlapping of mapped diagram elements is solved by different methods. Based on general considerations, it is possible to point out where a certain transition should be displaced to and how it should be mapped if the solution exists at all. However, if one does not imagine how the diagram will look as a whole, it is not easy to <b>do </b>this. <b>If </b>one transition line overlaps another line parallel to the first one (the distance between them is smaller than the height of figures denoting the wavelength), then several possibilities of layout are available. Firstly, a transition line can be moved to the right or to the left, segments presenting the levels can be extended if it is necessary. Secondly, a transition can be drawn in the form of two and more connected segments. While implementing the first possibility, one should take into account the presence of transitions from the left and right. If moving the line we occur on another transition, then it is necessary to implement the second possibility or eliminate the line from the diagram (see Item 3 of the level selection algorithm). This is the initial form of the diagram (see Fig. 1).</p>
<p>A user can construct a diagram with his own settings that represent the necessary data part more completely and accurately. This can be done using algorithm parametrization. For scaling and more accurate positioning, we can introduce a maximal and minimal level energy placed on the diagram.</p>
<p>The program written in the Java Language, which implements the foregoing algorithm, creates in its window a Grotrian diagram. Data necessary for constructing the diagram are contained in the XML document [20], the program receives the reference to it as a parameter. The document contains designations of electronic configurations and terms for horizontal scanning, breaks <b>of </b>the vertical energy scale, data on energy levels and ionization limits, and data on transitions. At the bottom of the diagram, there are input fields for setting the maximal and minimal energy, and also two fields for selecting transitions from a certain range. We can also construct a detailed partial diagram.</p>
<p><b>IS architecture maintaining dynamic construction of Grotrian diagrams. </b>The described method for automatic construction <b>of </b>Grotrian diagrams <b>creates </b>prerequisites for organizing IS ensuring their dynamic construction by users' requests. This system should primarily implement possibilities that have already been tested on a number of such systems:</p>
<p>1)&nbsp;storage of massive information (hundreds of thousand records) on energy levels and atomic transitions of elements from the Periodic Table, and their ions;</p>
<p>2)&nbsp;effective organization of this information collection to ensure fast response to requests;</p>
<p>3)&nbsp;new data entry to IS;</p>
<p>4)&nbsp;tabulation of data on levels and spectra with selection tools, and sorting of selection.</p>
<p>In addition, the IS should ensure dynamic creation of a graphical data representation in the form of Grotrian diagrams by implementing the following possibilities:</p>
<p>1)&nbsp;the best choice of the number and composition of lines and transitions for default mapping in the canonical form;</p>
<p>2)&nbsp;user's setting of diagram properties;</p>
<p>3)&nbsp;selection of the necessary information from DB and dynamic (&quot;on the fly&quot;) construction of a diagram picture with readability optimization.</p>
<p>The IS is based on a database management system (DBMS) that provides standard means for access to large volumes of information units of the same type, makes its possible to create general data access procedures, implement queries, etc.</p>
<p>The IS is constructed in a three-level client-server architecture.</p>
<p>The server level of the system is represented by an SQL server that ensures data storage and selection by SQL queries. The client level is standard web-browser software supporting the Java Language.</p>
<p>The main functionality of the system is concentrated on the intermediate level that ensures subject logic of the system, forms SQL queries, implements a web-gateway to the system, and gives interface to it. The base of the intermediate level is LEMMA application server designed at the Novosibirsk State University [21]. This server uses actually its DB metamodel containing objective approach elements and mechanism maintaining sem-istructured data (XML fields), and makes it possible to construct complex user interfaces on the basis of methods of classes of objects defined in the conceptual data model. Each page of the user interface is called by http-query and initiates a certain method of a particular object, transferring the parameters to it. The called method according to user request organizes SQL query to DB. Based on the obtained data, the &quot;on the fly&quot; method generates an HTML/XML page to be transferred to the client.</p>
<p>Dynamic construction and mapping of Grotrian diagrams are implemented as follows. A query for diagram construction calls a method of class whose instances correspond to atoms and ions. This method generates a page and places in it a Java applet based on the described Java Program. The reference sent to the applet to a document containing information necessary for diagram drawing is a bar of call for a conjugate method (including the parameters) which is responsible for generating the required document with spectral data.</p>
<p>The intuitively obvious user interface based on the foregoing technologies ensures data receive according to the most frequently required queries, including:</p>
<p>-&nbsp;receiving tabulated information on levels of one or several elements;</p>
<p>-&nbsp;receiving tabulated information on transitions of one or several elements;</p>
<p>-&nbsp;receiving Grotrian diagrams on the given element and the set of parameters.</p>
<p>The base of the interface is presented by three pages, each of them is responsible for a certain type of request. The page &quot;Levels&quot; enables the user to make a detailed request for receiving information on energy levels of an atom or an ion, and presents results of this request. The form of request determines the choice of its parameters: the maximal and minimal energy, the configuration or term, energy units (eV cm<sup>-1</sup>), the list of mapped fields, and the height of output pages. These data are arranged in a table. Additional mechanisms ensure setting the representation (sorting in energy and configuration) on client's computer after receiving the data.</p>
<p>The page &quot;Transitions&quot; generates a query to receive the corresponding information. In the query parameters, it is possible to select elements, wavelength and variation (if the field is empty, all transitions are output), units (nanometers, angstroms), and permission to show complete information on the levels. Results can also be sorted in different parameters.</p>
<p>The page &quot;Graphics&quot; presents the form of selecting such Grotrian diagram parameters as a minimum and maximum intensity of displayed transitions, and minimum and maximum energy levels. The diagram itself is opened in a special window &quot;Output diagram&quot;.</p>
<p><b>Experience of information system construction. </b>An IS prototype &quot;Electronic atom structure&quot; implementing this function is presently constructed. The system is published in the Internet Network [22]. For approbation, the system was filled in with the latest data on a beryllium atom [12] whose electronic structure is described by the LS-bond.</p>
<p>During the approbation, particular attention was given to graphical representation. The Grotrian diagram obtained default for the beryllium atom is shown in Fig. 1.</p>
<p>Possible settings: choice of the energy range of displayed levels and selection of transitions with a certain wavelength; they facilitate reading and understanding the information from the diagram. For instance, the choice of the range in energy allows one to clearly distinguish Rydberg and autoionization states. Using a partial diagram, one can show all known transition lines. It is possible to mark certain wavelengths by different colors, it is merely necessary to input the wavelength value and the range of marking.</p>
<p>Based on work with other diagrams, we found out that the used selection algorithm ensures right choice of mapped levels and adequate readability of diagrams for a separate group of atoms of alkaline and alkaline-earth elements. Other groups of atoms require additional testing.</p>
<p class="center_text"><b>CONCLUSION</b></p>
<p>We proposed a schematic for constructing an IS to store, process, and represent data on electronic structures of atoms, that is, the characteristics of energy levels (configuration, term, energy, and lifetime) and radiation transitions (the observed and calculated wavelength, probability of transition, and relative intensity). A special feature of the system is the possibility of dynamic visualizing the atomic structure via automatic construction of Grotrian diagrams from DB information. The IS is oriented to working via web-server Internet, thereby a researcher can gain the necessary data. The implemented system prototype allows constructing a graphical representation in the form of Grotrian diagrams. The system functions in the Internet Network [22] and is partially filled in with the latest data on atoms of alkaline elements and also on atoms of beryllium, calcium, magnesium, neon, and ytterbium.</p>
<p>The system is intended for specialists and students dealing with problems of atomic spectroscopy, plasma, quantum electronics, and astrophysics.</p>
<p>The authors are grateful to S.G.Rautian and D.A.Shapiro for fruitful discussions.</p>
<p class="center_text"><b>REFERENCES</b></p>
<p>1.&nbsp;Ch.Moore, <i>Atomic Energy Levels, </i>NSRDS -NBS 35, Washington, vol. 1-3, 1971.</p>
<p>2.&nbsp;G.A.Odintsova and A.R.Striganov, <i>Tables of Spectral Lines for Neutral and Ionized Atoms </i>(in Russian), Energoizdat, Moscow, 1982.</p>
<p>3.&nbsp;S.G.Rautian and A.S.Yatsenko, <i>UFN, </i>vol. 169, no. 2, p. 217, 1999.</p>
<p>4.&nbsp;W.Grotrian, <i>Graphische Darstellung der Spektren von Atomen und Ionen mit Ein, Zwei und Drei Valenzelektronen, </i>Springer, Berlin, Bd. 2, 1928.</p>
<p>5.&nbsp;M.Yokozawa, M.Matsuzaki, T.Kamegaya, and M.Nakajima, <i>Grotrian Charts of Neutral and Singly Ionized Rare Gases in Vacuum UV-region </i>(NHK Laboratories, ser.183), NHK Laboratories Note, Tokyo, 1974.</p>
<p>6.&nbsp;Ch.Moore and P Merill, <i>Partial Grotrian Diagrams of AstrophysicalInterest, </i>NSRDS-NBS 23, Washington, 1968.</p>
<p>7.&nbsp;S.Baskin and J.Stoner, <i>Atomic Energy Levels and Grotrian Diagrams, </i>North Holland, Amsterdam, 1975-1982, vol. 1-4.</p>
<p>8.&nbsp;T.Shirai, J.Sugar, W. Wiese, et al., <i>Spectral Data for Highly Ionized Atoms: </i>Ti, V, Cr, Mn, Fe, Co, Ni, Cu, Kr, Mo, AIP, JPCRD, New York, 2000, Monograph no. 8.</p>
<p>9.&nbsp;A.S.Yatsenko, <i>Grotrian Diagrams of Neural Atoms </i>(in Russian), Novosibirsk, Nauka, 1993.</p>
<p>10.&nbsp;A.S.Yatsenko, <i>Grotrian Diagrams of Single Ions </i>(in Russian), Nauka, Novosibirsk, 1996.</p>
<p>11.&nbsp;A.Kramida and W.Martin, Journ. <i>Phys. and Chem. Ref. Data, </i>vol. 26, no. 5, p. 1185, 1997.</p>
<p>12.&nbsp;<a target="blank" href="http://physics.nist.gov">http://physics.nist.gov</a></p>
<p>13.&nbsp;<a target="blank" href="http://nedwww.ipac.caltech.edu/level5/Ewald/Grotrian/grotrian.html">http://nedwww.ipac.caltech.edu/level5/Ewald/Grotrian/grotrian.html</a></p>
<p>14.&nbsp;<a target="blank" href="http://physics.unI.edu/~tgay/ns/grotrian.htmI">http://physics.unI.edu/~tgay/ns/grotrian.htmI</a></p>
<p>15.&nbsp;<a target="blank" href="http://www.atomicengineeringcorp.com">http://www.atomicengineeringcorp.com</a></p>
<p>16.&nbsp;J.Seiko, <i>SQL for Professionals. Programming </i>(Russian transl.), Lori, Moscow, 2004.</p>
<p>17.&nbsp;<a target="blank" href="http://plasma-gate.weizmann.ac.il/Pubs.html">http://plasma-gate.weizmann.ac.il/Pubs.html</a>, (Yu.V .Ralchenko, <i>Atomic Data and Database on the Internet, </i>1996, (Prepr., WIS-96/4/Jan-PH)).</p>
<p>18.&nbsp;<a target="blank" href="http://plasma-gate.weizmann.ac.il/DBfApp.html">http://plasma-gate.weizmann.ac.il/DBfApp.html</a></p>
<p>19.&nbsp;A.S.Yatsenko, <i>Graphical Representations of Spectral Data on Atoms and Molecules </i>(in Russian), Novosibirsk, 2003, 20 p.</p>
<p>20.&nbsp;S.M.Ovchinnikov, <i>XML: Documenting Language on Worldwide Web </i>(in Russian), Maior, Moscow, 2001.</p>
<p>21.&nbsp;V.G.Kazakov, <i>Investigation, Development, and Application of Courseware Using Multimedia Technologies in Higher Education </i>(in Russian), NGU, Novosibirsk, 1999, 22 p.</p>
<p>22.&nbsp;<a href="http://asd.nsu.ru">http://asd.nsu.ru</a></p>

</div>
			</div>
<!--End of content-->