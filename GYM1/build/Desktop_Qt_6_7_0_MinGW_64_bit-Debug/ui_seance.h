/********************************************************************************
** Form generated from reading UI file 'seance.ui'
**
** Created by: Qt User Interface Compiler version 6.7.0
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_SEANCE_H
#define UI_SEANCE_H

#include <QtCore/QVariant>
#include <QtWidgets/QApplication>
#include <QtWidgets/QDialog>
#include <QtWidgets/QHeaderView>
#include <QtWidgets/QTableWidget>

QT_BEGIN_NAMESPACE

class Ui_Seance
{
public:
    QTableWidget *tableWidget;

    void setupUi(QDialog *Seance)
    {
        if (Seance->objectName().isEmpty())
            Seance->setObjectName("Seance");
        Seance->resize(528, 300);
        Seance->setStyleSheet(QString::fromUtf8("QLineEdit{\n"
"background-color:orange;\n"
"}"));
        tableWidget = new QTableWidget(Seance);
        tableWidget->setObjectName("tableWidget");
        tableWidget->setGeometry(QRect(20, 20, 481, 251));
        tableWidget->setStyleSheet(QString::fromUtf8("QWidget{background-color:orange;\n"
"		color: white;		\n"
"}"));

        retranslateUi(Seance);

        QMetaObject::connectSlotsByName(Seance);
    } // setupUi

    void retranslateUi(QDialog *Seance)
    {
        Seance->setWindowTitle(QCoreApplication::translate("Seance", "Dialog", nullptr));
    } // retranslateUi

};

namespace Ui {
    class Seance: public Ui_Seance {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_SEANCE_H
