Universitatea Tehnică a Moldovei\
Serviciul schimb de apartamente

LUCRARE DE AN\
la disciplina\
BAZE DE DATE

utilizând SGBD MySQL, PHP și stack-ul front-end la alegere\
pentru utilizarea potențială de către o agenție specializată.

**Dragomir Țurcanu\
MI-191**

**Chișinău 2020**

Conceptul SGBD
==============

Definiția SGBD
--------------

**SGBD** deabreviat sună ca ***S**istemă de **G**estiune a **B**azelor
de **D**ate*. Aceasta este o bază de date digitală bazată pe modelul
relațional de date, propusă de către E.F. Codd[^1] în 1970. Sistemă
softwre folosită la menținerea bazelor de date relaționale este un
**SGBD**. Majoritatea sistemelor bazelor de date relaționale folosesc
pentru comunicarea internă, interogări și modificări, limbajul ***SQL***
[^2].

Baze de date relaționale
------------------------

O bază de date relaționale se referă la o bază de date ce conține
informația salvată într-un mod structurat, folosind *randuri* și
*coloane*. Astfel devine simplă localizarea și accesul valorilor în
cadrul bazei de date. Este numită *\"relațională\"* deoarece valorile în
fiecare ***tabel*** sunt inter-conectate. Tabelele pot la fel fi
conectate către alte tabele. Structura relațională creează posibilitatea
de a executa ***operații*** asupra a o multitudine de tabele în același
moment.

![image](relational_databases_demo){width="\\textwidth"}

SGBD în practică
----------------

SGBD-urile sunt folosite foarte intensiv în practica de zi cu zi atât a
dezvoltatorilor soluțiilor software, atât și de către personalul *data
entry*, unitățile de management ale organizației, sau chiar
*stakeholder-ii* companiei. Majoritatea sistemelor moderne permit
accesarea și vizualizarea datelor în format ușor accesibilă, cu
funționalități performante de exportare pentru eventuală analitică
folosind instrumente dezvoltate pentru însărcinarea propusă.

Datele pot fi exportate în o multitudine bogată de formate pentru
operațiuni diferite cu datele propuse. Exemple exacte sunt ce urmează.

-   ***JSON***[^3] pentru includerea în aplicații web sau scripturi,
    perfect pentru dezvoltatorii de soluții softare, ce au nevoie de un
    format portabil pentru integrarea datelor în ***API***-uri[^4] și
    interfețe vizuale.

-   ***XLS***[^5], pentru includerea în aplicații de tip *spreadsheet*,
    de tip Microsoft Excel, sau Google Sheets. Este perfect potrivit
    pentru managerii sau contabilii unei companii pentru analiza și
    prognozartea informației pe baza datelor existente.

-   ***CSV***[^6], perfect pentru integrarea în scripturi și sisteme
    automatizate, de tipul instrumentariului pentru *machine
    learning*[^7]. Este formatul perfect pentru experții domeniului
    *data science* ce conlucrează cu dezvoltatorii pentru determinarea
    **pattern**-urilor în date, și prin urmare exploatarea parametrilor
    datelor pentru maximizarea profitabilității.

Cele mai răspândite sisteme de SGBD la momentul actual sunt următoarele.

-   Oracle DB

-   MySQL

-   PostreSQL

-   SQLite

-   Microsoft SQL Server

-   IBM DB2

Ultimii ani, tot mai populare au inceput să devină SGBD bazate pe baze
de date non-relaționale, așa numitul ***NoSQL***[^8]. Acestea permit un
nivel de flexibilitate a datelor mult mai înalt. Faptul dat este motivat
prin lipsa unei structuri bine definite, ce prin folosirea sistemei
***cheie-valoare***.

Lipsa structurii induce o pierdere în performanță, condiționată prin
complexititate indexării datelor, dar, beneficiul de bază este
posibilitatea modificării formatării, mărimii sau a encodării datelor,
***\"on the fly\"***[^9], ce este foarte benefic pentru o sistemă
software în creștere. De aia acest tip de baze de date a devenit foarte
popular în cadrul ***startup***-urilor, deoarece această alegere tehnică
le permite avansarea rapidă și modificarea datelor fără riscul de a
strica datele.

Exemple ale astfel de SGBD sunt următoarele.

-   MongoDB

-   Redis

-   Amazon DynamoDB

-   Oracle NoSQL DB

Modelarea Datelor
=================

Modelul Logic
-------------

[^1]: <https://en.wikipedia.org/wiki/Edgar_F._Codd>

[^2]: <https://en.wikipedia.org/wiki/SQL>

[^3]: <https://en.wikipedia.org/wiki/JSON>

[^4]: <https://en.wikipedia.org/wiki/API>

[^5]: <https://en.wikipedia.org/wiki/Microsoft_Excel>

[^6]: <https://en.wikipedia.org/wiki/Comma-separated_values>

[^7]: <https://en.wikipedia.org/wiki/Machine_learning>

[^8]: <https://en.wikipedia.org/wiki/NoSQL>

[^9]: În mișcare
